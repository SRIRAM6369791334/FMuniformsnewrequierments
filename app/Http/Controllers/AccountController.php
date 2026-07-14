<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\BulkOrder;
use App\Models\UserAddress;
// use App\Models\State;

class AccountController extends Controller
{
    public function showAccount()
    {
        $user = Auth::user();

        // Get user's orders with pagination
        $orders = Order::where('user_id', $user->id)
            ->orderBy('date_ordered_on', 'desc')
            ->paginate(10);

        // Get user's bulk orders
        $bulkOrders = BulkOrder::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get user's addresses from user_addresses table
        $userAddresses = UserAddress::where('user_id', $user->id)
            ->orderBy('address_type_id')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group addresses by type
        $addressesByType = $userAddresses->groupBy('address_type_id');

        // Get all order IDs for reference (if needed)
        $paginatedOrderNumbers = $orders->pluck('order_id');

        // Check if user has bulk orders
        $hasBulkOrders = $bulkOrders->count() > 0;

        // Get state information if exists
        $state = null; // No state for now

        // Get registration request data if exists (for fallback address info)
        $registrationRequest = null; // This would need to be implemented based on your registration system

        return view('pages.account', compact('user', 'orders', 'bulkOrders', 'hasBulkOrders', 'paginatedOrderNumbers', 'state', 'registrationRequest', 'userAddresses', 'addressesByType'));
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');

            // Generate unique filename
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Store directly in public/uploads directory
            $image->move(public_path('uploads'), $filename);
            $path = 'uploads/' . $filename;

            // Delete old profile image if exists
            if ($user->profile_image) {
                $oldPath = public_path($user->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Update user profile image
            $user->profile_image = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully!',
                'image_url' => asset($path)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image file provided.'
        ], 400);
    }

    /**
     * Get bulk order details for AJAX request
     */
    public function getBulkOrderDetails(Request $request, $bulkOrderId)
    {
        \Log::info('getBulkOrderDetails called', ['bulkOrderId' => $bulkOrderId, 'user' => Auth::id()]);

        $user = Auth::user();

        if (!$user) {
            \Log::error('User not authenticated');
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $bulkOrder = BulkOrder::where('bulk_order_id', $bulkOrderId)
            ->where('user_id', $user->id)
            ->first();

        if (!$bulkOrder) {
            \Log::info('Bulk order not found', ['bulkOrderId' => $bulkOrderId, 'user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'Bulk order not found.'
            ], 404);
        }

        \Log::info('Bulk order found', ['bulkOrder' => $bulkOrder->toArray()]);

        return response()->json([
            'success' => true,
            'bulkOrder' => [
                'bulk_order_id' => $bulkOrder->bulk_order_id,
                'institution' => $bulkOrder->institution,
                'uniform_type' => $bulkOrder->uniform_type,
                'quantity' => $bulkOrder->quantity,
                'budget' => $bulkOrder->budget,
                'message' => $bulkOrder->message,
                'status' => $bulkOrder->status,
                'created_at' => $bulkOrder->created_at->format('d-m-Y'),
                'updated_at' => $bulkOrder->updated_at->format('d-m-Y'),
            ]
        ]);
    }

    /**
     * Get order details for AJAX request
     */
    public function getOrderDetails(Request $request, $orderId)
    {
        \Log::info('getOrderDetails called', ['orderId' => $orderId, 'user' => Auth::id()]);

        $user = Auth::user();

        if (!$user) {
            \Log::error('User not authenticated');
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $order = Order::with('orderAddresses')->where('order_id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            \Log::info('Order not found', ['orderId' => $orderId, 'user_id' => $user->user_id]);
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        \Log::info('Order found', ['order' => $order->toArray()]);

        // Get order items from product_slots table
        $orderItems = \App\Models\ProductSlot::where('order_id', $orderId)
            ->orderBy('id')
            ->get();

        $items = [];
        foreach ($orderItems as $item) {
            $variantInfo = [];
            if ($item->size_value) $variantInfo[] = 'Size: ' . $item->size_value;
            if ($item->color_value) $variantInfo[] = 'Color: ' . $item->color_value;

            $items[] = [
                'product_name' => $item->product_name,
                'product_image' => $item->product_image,
                'color_value' => $item->color_value,
                'size_value' => $item->size_value,
                'variant_info' => implode(', ', $variantInfo),
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->product_rate,
                'total_price' => (float) $item->product_total,
            ];
        }

        // Get billing and shipping addresses from orderAddresses relationship
        $billingAddress = null;
        $shippingAddress = null;

        foreach ($order->orderAddresses as $address) {
            $addressText = $address->address_line_one;
            if ($address->address_line_two) $addressText .= ', ' . $address->address_line_two;
            if ($address->landmark) $addressText .= ', ' . $address->landmark;
            if ($address->city) $addressText .= ', ' . $address->city;
            if ($address->state) $addressText .= ', ' . $address->state;
            if ($address->pincode) $addressText .= ' ' . $address->pincode;

            // detailed check for billing vs shipping
            // Type 1 is Home/Billing, Type 2 is Work/Shipping
            $isBilling = $address->address_type_id == 1 || in_array(strtolower($address->address_type_name), ['billing', 'home']);
            $isShipping = $address->address_type_id == 2 || in_array(strtolower($address->address_type_name), ['shipping', 'work']);

            if ($isBilling) {
                $billingAddress = $addressText;
            } elseif ($isShipping) {
                $shippingAddress = $addressText;
            }
        }

        return response()->json([
            'success' => true,
            'order' => [
                'order_id' => $order->order_id,
                'order_number' => $order->order_id, // Using order_id as order_number
                'order_date' => $order->date_ordered_on->format('d-m-Y'),
                'payment_status' => $order->payment_status,
                'delivery_status' => $order->delivery_status,
                'total_amount' => (float) $order->total_amount,
                'shipping_amount' => (float) $order->delivery_charge,
                'grand_total_amount' => (float) $order->grand_total_amount,
                'billing_address' => $billingAddress ?: 'No address available',
                'shipping_address' => $shippingAddress,
                'order_notes' => $order->order_notes,
                'items' => $items
            ]
        ]);
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $user = Auth::user();

        $order = Order::where('order_id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        if (!$order->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be cancelled.'
            ], 400);
        }

        $order->update(['delivery_status' => 3]); // Assuming 3 is cancelled status

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.'
        ]);
    }

    /**
     * Store new user address
     */
    public function storeAddress(Request $request)
    {
        $request->validate([
            'address_first_name' => 'required|string|max:255',
            'address_last_name' => 'required|string|max:255',
            'address_line_one' => 'required|string|max:500',
            'address_line_two' => 'nullable|string|max:500',
            'landmark' => 'nullable|string|max:255',
            'area_name' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|regex:/^[0-9]{6}$/',
            'address_phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'address_type_id' => 'required|integer|in:1,2,3',
            'address_type_others_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Create address username from first and last name
        $addressUsername = $request->address_first_name . ' ' . $request->address_last_name;

        $address = UserAddress::create([
            'address_username' => $addressUsername,
            'address_first_name' => $request->address_first_name,
            'address_last_name' => $request->address_last_name,
            'user_id' => $user->id,
            'address_line_one' => $request->address_line_one,
            'address_line_two' => $request->address_line_two,
            'landmark' => $request->landmark,
            'area_name' => $request->area_name,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address_phone_number' => $request->address_phone_number,
            'address_type_id' => $request->address_type_id,
            'address_type_name' => $this->getAddressTypeName($request->address_type_id),
            'address_type_others_name' => $request->address_type_id == 3 ? $request->address_type_others_name : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully.',
            'address' => $address
        ]);
    }

    /**
     * Update user address
     */
    public function updateAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'address_first_name' => 'required|string|max:255',
            'address_last_name' => 'required|string|max:255',
            'address_line_one' => 'required|string|max:500',
            'address_line_two' => 'nullable|string|max:500',
            'landmark' => 'nullable|string|max:255',
            'area_name' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|regex:/^[0-9]{6}$/',
            'address_phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'address_type_id' => 'required|integer|in:1,2,3',
            'address_type_others_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $address = UserAddress::where('id', $request->address_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.'
            ], 404);
        }

        // Create address username from first and last name
        $addressUsername = $request->address_first_name . ' ' . $request->address_last_name;

        $address->update([
            'address_username' => $addressUsername,
            'address_first_name' => $request->address_first_name,
            'address_last_name' => $request->address_last_name,
            'address_line_one' => $request->address_line_one,
            'address_line_two' => $request->address_line_two,
            'landmark' => $request->landmark,
            'area_name' => $request->area_name,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address_phone_number' => $request->address_phone_number,
            'address_type_id' => $request->address_type_id,
            'address_type_name' => $this->getAddressTypeName($request->address_type_id),
            'address_type_others_name' => $request->address_type_id == 3 ? $request->address_type_others_name : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully.',
            'address' => $address
        ]);
    }

    /**
     * Get address details for editing
     */
    public function showAddress($addressId)
    {
        $user = Auth::user();
        $address = UserAddress::where('id', $addressId)
            ->where('user_id', $user->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    /**
     * Delete user address
     */
    public function destroyAddress($addressId)
    {
        $user = Auth::user();
        $address = UserAddress::where('id', $addressId)
            ->where('user_id', $user->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully.'
        ]);
    }

    /**
     * Get address type name
     */
    private function getAddressTypeName($typeId)
    {
        $types = [
            1 => 'Home',
            2 => 'Work',
            3 => 'Others'
        ];

        return $types[$typeId] ?? 'Others';
    }
}
