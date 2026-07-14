<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductTracking;
use App\Services\ShiprocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketController extends Controller
{
    protected $shiprocket;

    public function __construct(ShiprocketService $shiprocket)
    {
        $this->shiprocket = $shiprocket;
    }

    /**
     * Handle Shiprocket webhook for status updates
     */
    public function handleWebhook(Request $request)
    {
        Log::info('Shiprocket webhook received', [
            'payload' => $request->all()
        ]);

        try {
            $data = $request->all();

            // Shiprocket sends different event types
            $awbCode = $data['awb'] ?? null;
            $orderId = $data['order_id'] ?? null;
            $currentStatus = $data['current_status'] ?? null;
            $currentStatusId = $data['current_status_id'] ?? null;
            $shipmentStatus = $data['shipment_status'] ?? null;

            // Find order by AWB code or Shiprocket order ID
            $order = null;
            
            if ($awbCode) {
                $order = Order::where('awb_code', $awbCode)->first();
            }
            
            if (!$order && $orderId) {
                // Try to find by our order_id first
                $order = Order::where('order_id', $orderId)->first();
                
                // If not found, try by shiprocket_order_id
                if (!$order) {
                    $order = Order::where('shiprocket_order_id', $orderId)->first();
                }
            }

            if (!$order) {
                Log::warning('Shiprocket webhook: Order not found', [
                    'awb_code' => $awbCode,
                    'order_id' => $orderId
                ]);
                return response()->json(['status' => 'order_not_found'], 404);
            }

            // Map Shiprocket status to our delivery status
            $deliveryStatus = $this->mapShiprocketStatus($currentStatusId ?? 0);

            // Update order status
            $order->update([
                'delivery_status' => $deliveryStatus,
                'current_status' => $deliveryStatus,
            ]);

            Log::info('Order status updated from Shiprocket webhook', [
                'order_id' => $order->order_id,
                'shiprocket_status' => $currentStatus,
                'new_delivery_status' => $deliveryStatus
            ]);

            // Sync to product_tracking table for Dashboard
            $deliveredDate = ($deliveryStatus == 2 && $currentStatusId == 7) ? now()->toDateString() : null;
            ProductTracking::updateFromWebhook($order->order_id, $deliveryStatus, $deliveredDate);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Shiprocket webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Map Shiprocket status ID to our delivery status
     */
    protected function mapShiprocketStatus($statusId): int
    {
        // Shiprocket status IDs mapped to our system
        // See: https://apidocs.shiprocket.in/#track-order
        $statusMap = [
            1 => 0,   // AWB Assigned -> Pending
            2 => 0,   // Label Generated -> Pending
            3 => 0,   // Pickup Scheduled -> Pending
            4 => 1,   // Pickup Queued -> Processing
            5 => 1,   // Manifest Generated -> Processing
            6 => 2,   // Shipped -> Shipped
            7 => 2,   // Delivered -> Delivered (we use 2 for both shipped and delivered)
            8 => 3,   // Cancelled -> Cancelled
            9 => 4,   // RTO Initiated -> RTO
            10 => 4,  // RTO Delivered -> RTO
            11 => 0,  // Pending -> Pending
            12 => 0,  // Lost -> Lost/Issue
            13 => 0,  // Pickup Error -> Error
            14 => 2,  // RTO Acknowledged -> RTO Process
            15 => 2,  // Out for Pickup -> In Transit
            16 => 2,  // In Transit -> In Transit
            17 => 2,  // Out for Delivery -> Out for Delivery
            18 => 2,  // Pickup Rescheduled -> Rescheduled
            19 => 0,  // Undelivered -> Failed Delivery
            20 => 0,  // Damaged -> Damaged
            21 => 0,  // Disposed Off -> Disposed
            22 => 2,  // Partial Delivered -> Partial
        ];

        return $statusMap[$statusId] ?? 0;
    }

    /**
     * Get tracking information for an order
     */
    public function track($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Try tracking by AWB code first
        if ($order->awb_code) {
            $tracking = $this->shiprocket->getTracking($order->awb_code);
        } else {
            // Fall back to order ID tracking
            $tracking = $this->shiprocket->getTrackingByOrderId($order->order_id);
        }

        return response()->json($tracking);
    }

    /**
     * Manually sync order to Shiprocket
     */
    public function syncOrder($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Check if already synced
        if ($order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order already synced to Shiprocket',
                'shiprocket_order_id' => $order->shiprocket_order_id
            ]);
        }

        $result = $this->shiprocket->createOrder($order);

        return response()->json($result);
    }

    /**
     * Cancel Shiprocket order
     */
    public function cancelOrder($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not synced with Shiprocket'
            ]);
        }

        $result = $this->shiprocket->cancelOrder($order->shiprocket_order_id);

        if ($result['success']) {
            $order->update([
                'is_cancelled' => 1,
                'delivery_status' => 3, // Cancelled status
            ]);
        }

        return response()->json($result);
    }

    /**
     * Generate AWB for an order
     */
    public function generateAWB($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->shiprocket_shipping_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not synced with Shiprocket or no shipment ID'
            ]);
        }

        if ($order->awb_code) {
            return response()->json([
                'success' => true,
                'message' => 'AWB already generated',
                'awb_code' => $order->awb_code
            ]);
        }

        $result = $this->shiprocket->generateAWB($order->shiprocket_shipping_id);

        if ($result['success'] && isset($result['awb_code'])) {
            $order->update([
                'awb_code' => $result['awb_code']
            ]);
        }

        return response()->json($result);
    }

    /**
     * Request pickup for an order
     */
    public function requestPickup($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->shiprocket_shipping_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not synced with Shiprocket'
            ]);
        }

        $result = $this->shiprocket->requestPickup($order->shiprocket_shipping_id);

        return response()->json($result);
    }

    /**
     * Public tracking page
     */
    public function trackingPage(Request $request, $orderId = null)
    {
        $order = null;
        $tracking = null;
        $error = null;

        // Use order ID from URL or from search form
        $searchOrderId = $orderId ?? $request->input('order_id');

        if ($searchOrderId) {
            $order = Order::where('order_id', $searchOrderId)->first();

            if (!$order) {
                $error = 'Order not found. Please check your order ID.';
            } else {
                // Get tracking info
                if ($order->awb_code) {
                    $trackingResult = $this->shiprocket->getTracking($order->awb_code);
                    if ($trackingResult['success']) {
                        $tracking = $trackingResult;
                    }
                } elseif ($order->shiprocket_order_id) {
                    $trackingResult = $this->shiprocket->getTrackingByOrderId($order->order_id);
                    if ($trackingResult['success']) {
                        $tracking = $trackingResult;
                    }
                }
            }
        }

        return view('pages.tracking', compact('order', 'tracking', 'error', 'searchOrderId'));
    }

    /**
     * Generate shipping label
     */
    public function generateLabel($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->shiprocket_shipping_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not synced with Shiprocket'
            ]);
        }

        $result = $this->shiprocket->generateLabel($order->shiprocket_shipping_id);

        return response()->json($result);
    }

    /**
     * Generate invoice
     */
    public function generateInvoice($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not synced with Shiprocket'
            ]);
        }

        $result = $this->shiprocket->generateInvoice($order->shiprocket_order_id);

        return response()->json($result);
    }

    /**
     * Get available couriers for an order
     */
    public function getAvailableCouriers($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Get shipping address for delivery pincode
        $addresses = $order->orderAddresses;
        $shippingAddress = $addresses->where('address_type_id', 2)->first() ?? $addresses->first();

        if (!$shippingAddress) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping address not found'
            ]);
        }

        // Calculate weight from order items
        $orderItems = \App\Models\ProductSlot::where('order_id', $order->order_id)->get();
        $totalWeight = $this->calculateOrderWeight($orderItems);

        // Default pickup pincode - should be configured
        $pickupPincode = config('services.shiprocket.pickup_pincode', '560001');
        $deliveryPincode = $shippingAddress->pincode;
        $codAmount = $order->payment_method === 'cod' ? $order->grand_total_amount : 0;

        Log::info('Getting couriers with calculated weight', [
            'order_id' => $orderId,
            'weight' => $totalWeight,
            'pickup' => $pickupPincode,
            'delivery' => $deliveryPincode
        ]);

        $result = $this->shiprocket->getAvailableCouriers(
            $pickupPincode,
            $deliveryPincode,
            $codAmount,
            $totalWeight
        );

        return response()->json($result);
    }

    /**
     * Calculate total weight from order/cart items
     */
    protected function calculateOrderWeight($items): float
    {
        $totalWeight = 0;
        
        foreach ($items as $item) {
            $itemWeight = 0;
            
            // Try to get weight from variant first
            $variantId = $item->product_varient_id ?? $item->variant_id ?? null;
            if ($variantId) {
                $variant = \App\Models\ProductVariant::find($variantId);
                if ($variant && $variant->weight > 0) {
                    $itemWeight = (float) $variant->weight;
                }
            }
            
            // Fallback to product weight if variant weight not set
            $productId = $item->product_id ?? null;
            if ($itemWeight == 0 && $productId) {
                $product = \App\Models\Product::find($productId);
                if ($product && $product->weight > 0) {
                    $itemWeight = (float) $product->weight;
                }
            }
            
            // If still no weight, use default (0.3 kg per item for uniforms)
            if ($itemWeight == 0) {
                $itemWeight = 0.3;
            }
            
            $quantity = (int) ($item->quantity ?? $item->product_quantity ?? 1);
            $totalWeight += $itemWeight * $quantity;
        }
        
        // Ensure minimum weight of 0.5 kg
        return max(0.5, $totalWeight);
    }

    /**
     * Check available couriers for checkout (PUBLIC - no auth required)
     * Called from checkout page when customer enters pincode
     */
    public function checkCouriers(Request $request)
    {
        $request->validate([
            'delivery_pincode' => 'required|digits:6',
            'weight' => 'nullable|numeric|min:0.1|max:50',
            'cod_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            // Get pickup pincode from config
            $pickupPincode = config('services.shiprocket.pickup_pincode', '560001');
            $deliveryPincode = $request->input('delivery_pincode');
            $codAmount = $request->input('cod_amount', 0);
            
            // Calculate weight from cart if not explicitly provided or to be safer
            $userId = Auth::id();
            $ipAddress = $this->getClientIp(); // Helper to get IP
            $cartItems = \App\Models\Cart::getUserCart($userId, $ipAddress);
            
            $weight = $this->calculateOrderWeight($cartItems);
            
            // If request has weight and it's higher, maybe use that? 
            // But calculating from DB is more reliable for "automatic" weight usage.
            if ($request->has('weight') && $request->input('weight') > $weight) {
                $weight = $request->input('weight');
            }

            Log::info('Checking couriers for pincode with calculated weight', [
                'pickup' => $pickupPincode,
                'delivery' => $deliveryPincode,
                'weight' => $weight,
                'cod' => $codAmount
            ]);

            $result = $this->shiprocket->getAvailableCouriers(
                $pickupPincode,
                $deliveryPincode,
                $codAmount,
                $weight
            );

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to fetch couriers',
                    'couriers' => []
                ]);
            }

            // Format couriers for frontend
            $couriers = [];
            if (isset($result['couriers']) && is_array($result['couriers'])) {
                foreach ($result['couriers'] as $courier) {
                    $couriers[] = [
                        'courier_id' => $courier['courier_company_id'] ?? $courier['id'] ?? null,
                        'courier_name' => $courier['courier_name'] ?? $courier['name'] ?? 'Unknown',
                        'rate' => $courier['rate'] ?? $courier['freight_charge'] ?? 0,
                        'etd' => $courier['etd'] ?? (isset($courier['estimated_delivery_days']) ? $courier['estimated_delivery_days'] . ' days' : 'N/A'),
                        'estimated_delivery_days' => $courier['estimated_delivery_days'] ?? 5,
                        'cod_available' => ($courier['cod'] ?? 1) == 1,
                        'min_weight' => $courier['min_weight'] ?? 0.5,
                        'rating' => $courier['rating'] ?? 4.0,
                    ];
                }

                // Sort by rate (cheapest first)
                usort($couriers, function($a, $b) {
                    return $a['rate'] <=> $b['rate'];
                });
            }

            return response()->json([
                'success' => true,
                'couriers' => $couriers,
                'pickup_pincode' => $pickupPincode,
                'delivery_pincode' => $deliveryPincode,
                'calculated_weight' => $weight
            ]);

        } catch (\Exception $e) {
            Log::error('Check couriers error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to check courier availability',
                'couriers' => []
            ], 500);
        }
    }

    /**
     * Get client IP (helper needed because ShiprocketController doesn't extend BaseController with this method)
     */
    protected function getClientIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
    }
}
