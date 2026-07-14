<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductSlot;
use App\Models\UserAddress;
use App\Models\ProductOrderUserAddress;
use App\Models\ProductTracking;
use App\Services\ShiprocketService;
use App\Notifications\OrderPlacedUserNotification;
use App\Notifications\OrderPlacedAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;

class CartController extends Controller
{
    /**
     * Display the user's cart
     */
    public function index()
    {
        $userId = Auth::id();
        $guestId = session('guest_user_id');

        // Debug output
        \Log::info('Cart Debug', [
            'userId' => $userId,
            'guestId' => $guestId,
            'auth_check' => Auth::check()
        ]);

        // Automatically transfer guest cart to user account if logged in
        if ($userId) {
            $transferredCount = Cart::transferGuestCart($guestId, $userId);
            if ($transferredCount > 0) {
                \Log::info('Guest cart transferred', [
                    'user_id' => $userId,
                    'guest_id' => $guestId,
                    'transferred_count' => $transferredCount
                ]);
            }
        }

        // Automatically clean up orphaned cart items first
        $this->cleanupOrphanedItems($userId, $guestId);

        // Get cart items with eager loading to prevent N+1 queries
        $cartItems = Cart::getUserCart($userId, $guestId);

        \Log::info('Cart Items Retrieved', [
            'count' => $cartItems->count(),
            'items' => $cartItems->toArray()
        ]);

        $cartTotal = Cart::getCartTotal($userId, $guestId);
        $itemCount = Cart::getCartItemCount($userId, $guestId);

        return view('pages.cart', compact('cartItems', 'cartTotal', 'itemCount'));
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:99',
            'product_variant_id' => 'nullable|exists:product_varient,id',
            'selected_size' => 'nullable|string|max:50',
            'selected_color' => 'nullable|string|max:50',
        ]);

        // Enforce Login Check
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'redirect_to_login' => true,
                    'url' => route('login')
                ], 200);
            }
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $guestId = session('guest_user_id');
        $quantity = $request->quantity ?? 1;

        // Single optimized query to get product and variant with stock info
        $productQuery = Product::query();

        if ($request->product_variant_id) {
            $productQuery->with(['variants' => function($q) use ($request) {
                $q->where('id', $request->product_variant_id);
            }]);
        }

        $product = $productQuery->find($request->product_id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Determine stock based on variant or product
        $availableStock = $product->product_quantity;
        $variant = null;

        if ($request->product_variant_id && $product->variants->isNotEmpty()) {
            $variant = $product->variants->first();
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product variant not found'
                ], 404);
            }
            $availableStock = $variant->variant_quantity;
        }

        if ($availableStock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ]);
        }

        if ($quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => "Only {$availableStock} items available in stock"
            ]);
        }

        // Optimized cart addition - no redundant queries
        $cartItem = $this->addToCartOptimized(
            $product,
            $variant,
            $quantity,
            $request->selected_size,
            $request->selected_color,
            $userId,
            $guestId
        );

        if ($cartItem) {
            $itemCount = Cart::getCartItemCount($userId, $guestId);
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully!',
                'cart_count' => $itemCount,
                'cart_item' => $cartItem
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to add item to cart'
        ], 500);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:99',
            ]);

            $userId = Auth::id();
            $guestId = session('guest_user_id');

            // Optimized: Eager load product and variant relationships
            $cartItem = Cart::with(['product', 'productVariant'])->findOrFail($id);

            // Check if user can access this cart item
            $isAuthorized = false;
            
            \Log::info('Cart Update Authorization Check', [
                'item_id' => $id,
                'current_user_id' => $userId,
                'item_user_id' => $cartItem->user_id,
                'current_guest_id' => $guestId,
                'item_guest_id' => $cartItem->guest_user_id
            ]);

            if ($cartItem->user_id) {
                // If item is owned by a user, it must match current user (use loose comparison for type safety)
                $isAuthorized = ($cartItem->user_id == $userId);
            } else {
                // If item is a guest item, guest_user_id must match
                $isAuthorized = ($cartItem->guest_user_id === $guestId);
            }

            if (!$isAuthorized) {
                \Log::warning('Cart Update Unauthorized', [
                    'item_id' => $id,
                    'user_id' => $userId,
                    'item_user_id' => $cartItem->user_id,
                    'guest_id' => $guestId,
                    'item_guest_id' => $cartItem->guest_user_id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Use eager loaded product relationship
            $product = $cartItem->product;
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product no longer available'
                ], 400);
            }

            // Check stock availability - check variant stock if variant is selected
            $availableStock = 0;
            if ($cartItem->product_varient_id) {
                // Check variant stock using eager loaded relationship
                $variant = $cartItem->productVariant;
                if (!$variant) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product variant no longer available'
                    ], 400);
                }
                $availableStock = $variant->variant_quantity;
            } else {
                // Check product stock
                $availableStock = $product->product_quantity;
            }

            if ($availableStock <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock'
                ]);
            }

            if ($request->quantity > $availableStock) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$availableStock} items available in stock"
                ]);
            }

            $unitPrice = $cartItem->price ?? $product->product_price;
            $cartItem->update([
                'product_quantity' => $request->quantity,
                'price' => $unitPrice // Ensure price is set
            ]);

            $itemSubtotal = $request->quantity * $unitPrice;
            $cartTotal = Cart::getCartTotal($userId, $guestId);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_total' => $cartTotal,
                'item_subtotal' => $itemSubtotal
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart update error', [
                'cart_id' => $id,
                'quantity' => $request->quantity ?? null,
                'user_id' => Auth::id(),
                'guest_id' => $this->getGuestId(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error occurred. Please try again.'
            ], 500);
        }
    }



    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $guestId = session('guest_user_id');

        $cartItem = Cart::findOrFail($id);

        // Check if user can access this cart item
        $isAuthorized = false;
        
        \Log::info('Cart Destroy Authorization Check', [
            'item_id' => $id,
            'current_user_id' => $userId,
            'item_user_id' => $cartItem->user_id,
            'current_guest_id' => $guestId,
            'item_guest_id' => $cartItem->guest_user_id
        ]);

        if ($cartItem->user_id) {
            // If item is owned by a user, it must match current user (use loose comparison for type safety)
            $isAuthorized = ($cartItem->user_id == $userId);
        } else {
            // If item is a guest item, guest_user_id must match
            $isAuthorized = ($cartItem->guest_user_id === $guestId);
        }

        if (!$isAuthorized) {
            \Log::warning('Cart Destroy Unauthorized', [
                'item_id' => $id,
                'user_id' => $userId,
                'item_user_id' => $cartItem->user_id,
                'guest_id' => $guestId,
                'item_guest_id' => $cartItem->guest_user_id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $cartItem->delete();

        $cartTotal = Cart::getCartTotal($userId, $guestId);
        $itemCount = Cart::getCartItemCount($userId, $guestId);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'cart_total' => $cartTotal,
            'cart_count' => $itemCount
        ]);
    }

    /**
     * Check if product is in cart
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_varient,id',
        ]);

        $userId = Auth::id();
        $guestId = session('guest_user_id');

        $isInCart = Cart::isInCart($request->product_id, $request->product_variant_id, $userId, $guestId);

        return response()->json([
            'in_cart' => $isInCart
        ]);
    }

    /**
     * Check multiple products in cart (batch request)
     */
    public function checkMultiple(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.variant_id' => 'nullable|exists:product_varient,id',
        ]);

        $userId = Auth::id();
        $guestId = session('guest_user_id');
        $products = $request->input('products', []);

        $results = [];

        // Batch check all products in a single query for better performance
        if (!empty($products)) {
            $productIds = array_column($products, 'product_id');
            $variantIds = array_filter(array_column($products, 'variant_id'));

            // Get all cart items for this user/guest in one query
            $cartQuery = Cart::query();
            if ($userId) {
                $cartQuery->where('user_id', $userId);
            } elseif ($guestId) {
                $cartQuery->where('guest_user_id', $guestId)->whereNull('user_id');
            }

            $cartItems = $cartQuery->whereIn('product_id', $productIds)->get();

            // Create lookup map for faster checking
            $cartLookup = [];
            foreach ($cartItems as $item) {
                $key = $item->product_id . '-' . ($item->product_varient_id ?: '');
                $cartLookup[$key] = true;
            }

            // Check each requested product against the cart lookup
            foreach ($products as $product) {
                $key = $product['product_id'] . '-' . ($product['variant_id'] ?: '');
                $results[$key] = isset($cartLookup[$key]);
            }
        }

        return response()->json([
            'results' => $results
        ]);
    }

    /**
     * Get cart count for header/navbar
     */
    public function count()
    {
        $userId = Auth::id();
        $guestId = session('guest_user_id');

        $count = Cart::getCartItemCount($userId, $guestId);

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $userId = Auth::id();
        $guestId = session('guest_user_id');

        $query = Cart::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestId) {
            $query->where('guest_user_id', $guestId)->whereNull('user_id');
        }

        $query->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully!'
        ]);
    }

    /**
     * Transfer guest cart to user account (called after login)
     */
    public function transfer()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $userId = Auth::id();
        $guestId = session('guest_user_id');

        $transferredCount = Cart::transferGuestCart($guestId, $userId);

        return response()->json([
            'success' => true,
            'message' => "Transferred {$transferredCount} items from guest cart",
            'transferred_count' => $transferredCount
        ]);
    }

    /**
     * Clean up orphaned cart items (products that no longer exist)
     */
    public function cleanup()
    {
        $userId = Auth::id();
        $guestId = session('guest_user_id');

        $query = Cart::with('product');

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestId) {
            $query->where('guest_user_id', $guestId)->whereNull('user_id');
        }

        $cartItems = $query->get();
        $removedCount = 0;

        foreach ($cartItems as $item) {
            if (!$item->product) {
                $item->delete();
                $removedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Cleaned up {$removedCount} orphaned cart items",
            'removed_count' => $removedCount
        ]);
    }

    /**
     * Clean up orphaned cart items automatically
     */
    private function cleanupOrphanedItems($userId, $guestId)
    {
        $query = Cart::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestId) {
            $query->where('guest_user_id', $guestId)->whereNull('user_id');
        }

        $cartItems = $query->get();
        
        if ($cartItems->isEmpty()) {
            return;
        }

        $removedCount = 0;

        // Optimized: Batch load all product IDs in a single query
        $productIds = $cartItems->pluck('product_id')->unique()->filter();
        $existingProductIds = Product::whereIn('id', $productIds)
            ->pluck('id')
            ->toArray();

        foreach ($cartItems as $item) {
            // Check if product exists using in-memory lookup
            $productExists = in_array($item->product_id, $existingProductIds);

            \Log::info('Cleanup Check', [
                'cart_item_id' => $item->id,
                'product_id' => $item->product_id,
                'product_exists' => $productExists
            ]);

            if (!$productExists) {
                $item->delete();
                $removedCount++;
                \Log::info('Removed orphaned cart item', ['cart_item_id' => $item->id]);
            }
        }

        if ($removedCount > 0) {
            \Log::info('Cleanup completed', ['removed_count' => $removedCount]);
        }
    }

    /**
     * Show checkout page
     */
    public function showCheckout()
    {
        $userId = Auth::id();
        $guestId = session('guest_user_id');

        // Check if there's pending checkout data from failed payment
        $pendingCheckout = session('checkout_data');
        if ($pendingCheckout) {
            // For pending checkout, always reload cart items from database to ensure relationships are loaded
            // This fixes the issue where session-stored arrays don't have model relationships
            $cartItems = Cart::getUserCart($userId, $guestId); // Get fresh cart data with relationships
            $cartTotal = Cart::getCartTotal($userId, $guestId);
            $itemCount = Cart::getCartItemCount($userId, $guestId);

            // Clear the pending checkout data since we're showing it
            session()->forget('checkout_data');

            \Log::info('Restored cart from pending checkout', [
                'user_id' => $userId,
                'item_count' => $itemCount
            ]);
        } else {
            // Normal checkout - transfer guest cart if logged in
            if ($userId) {
                $transferredCount = Cart::transferGuestCart($guestId, $userId);
                if ($transferredCount > 0) {
                    \Log::info('Guest cart transferred', [
                        'user_id' => $userId,
                        'guest_id' => $guestId,
                        'transferred_count' => $transferredCount
                    ]);
                }
            }

            // Automatically clean up orphaned cart items
            $this->cleanupOrphanedItems($userId, $guestId);

            $cartItems = Cart::getUserCart($userId, $guestId);
            $cartTotal = Cart::getCartTotal($userId, $guestId);
            $itemCount = Cart::getCartItemCount($userId, $guestId);
        }

        // Check if user is authenticated and get user data for auto-fill
        $isAuthenticated = Auth::check();
        $user = $isAuthenticated ? Auth::user()->load(['defaultAddress', 'addresses']) : null;
        $userAddresses = $isAuthenticated ? $user->addresses : null;
        $defaultAddress = $isAuthenticated ? $user->defaultAddress : null;

        // Check if this is a return from login (session-based)
        $isReturnFromLogin = session()->has('checkout_return');

        return view('pages.checkout', compact(
            'cartItems',
            'cartTotal',
            'itemCount',
            'isAuthenticated',
            'user',
            'userAddresses',
            'defaultAddress',
            'isReturnFromLogin'
        ));
    }

    /**
     * Process checkout - ONLY handles AJAX requests now
     */
    public function checkout(Request $request)
    {
        // Only allow AJAX requests - direct form submissions should not happen
        if (!$request->ajax() && !$request->wantsJson()) {
            \Log::error('Direct checkout form submission attempted - blocking', [
                'user_id' => Auth::id(),
                'ip_address' => $this->getClientIp(),
                'user_agent' => $request->header('User-Agent')
            ]);

            return redirect()->route('checkout')->with('error', 'Invalid request method. Please use the checkout form.');
        }

        \Log::info('AJAX Checkout started', [
            'user_id' => Auth::id(),
            'ip_address' => $this->getClientIp(),
            'request_data' => $request->all(),
            'headers' => [
                'accept' => $request->header('Accept'),
                'x-requested-with' => $request->header('X-Requested-With'),
                'content-type' => $request->header('Content-Type'),
            ]
        ]);

        try {
            return $this->processCheckoutAjax($request);
        } catch (\Exception $e) {
            \Log::error('AJAX Checkout error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Failed to initialize payment. Please try again.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if email already exists
     */
    public function checkEmailExists(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    /**
     * Set checkout return URL in session
     */
    public function setCheckoutReturn(Request $request)
    {
        session(['checkout_return' => 'checkout']);
        return response()->json(['success' => true]);
    }

    /**
     * Optimized add to cart method - checks for existing items first
     */
    private function addToCartOptimized($product, $variant, $quantity, $selectedSize, $selectedColor, $userId, $guestId)
    {
        // Determine price from variant or product
        $price = $product->product_price;
        if ($variant && $variant->variant_price) {
            $price = $variant->variant_price;
        }

        // FIRST: Check if item already exists in cart
        $existingQuery = Cart::where('product_id', $product->id);
        
        if ($variant) {
            $existingQuery->where('product_varient_id', $variant->id);
        } else {
            $existingQuery->whereNull('product_varient_id');
        }

        if ($userId) {
            $existingQuery->where('user_id', $userId);
        } elseif ($guestId) {
            $existingQuery->where('guest_user_id', $guestId)->whereNull('user_id');
        }

        $existingItem = $existingQuery->first();

        if ($existingItem) {
            // Update quantity of existing item
            $newQuantity = $existingItem->product_quantity + $quantity;
            $existingItem->update([
                'product_quantity' => $newQuantity
            ]);
            return $existingItem;
        }

        // Create new cart item
        $cartData = [
            'user_id' => $userId,
            'guest_user_id' => $userId ? null : $guestId, // Only set guest_user_id if not logged in
            'product_id' => $product->id,
            'product_varient_id' => $variant ? $variant->id : null,
            'product_quantity' => $quantity,
            'price' => $price,
            'product_name' => $product->product_name,
            'product_color' => $selectedColor,
            'product_size' => $selectedSize,
            'product_image' => $product->product_image ?? null,
        ];

        return Cart::create($cartData);
    }

    /**
     * Process AJAX checkout request
     */
    private function processCheckoutAjax(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|regex:/^[0-9]{6}$/',
            'payment_method' => 'required|in:cod,razorpay',
            'order_notes' => 'nullable|string|max:1000',
            'force_guest_checkout' => 'nullable|boolean',
            // Shipping address fields (optional)
            'shipping_first_name' => 'nullable|string|max:255',
            'shipping_last_name' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string|max:500',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_country' => 'nullable|string|max:255',
            'shipping_zip_code' => 'nullable|string|regex:/^[0-9]{6}$/',
        ]);

        $userId = Auth::id();
        $guestId = session('guest_user_id');

        // Get cart items
        $cartItems = Cart::getUserCart($userId, $guestId);

        if ($cartItems->isEmpty()) {
            throw new \Exception('Your cart is empty. Please add items to your cart before checkout.');
        }

        // Calculate total
        $cartTotal = Cart::getCartTotal($userId, $guestId);
        $ipAddress = $this->getClientIp();
        
        // Use shipping cost from selected courier if provided, otherwise default to 30.00
        $shippingCost = $request->input('shipping_cost') ? (float) $request->input('shipping_cost') : 30.00;
        $totalAmount = $cartTotal + $shippingCost;

        // Handle different payment methods
        $paymentMethod = $request->payment_method;

        // For Razorpay payments, create Razorpay order only (no database order yet)
        if ($paymentMethod === 'razorpay') {
            try {
                // Create Razorpay order directly using the API
                $razorpay = new \Razorpay\Api\Api(
                    config('services.razorpay.key_id'),
                    config('services.razorpay.key_secret')
                );

                $razorpayOrderData = [
                    'receipt' => 'checkout_' . time() . '_' . $userId,
                    'amount' => $totalAmount * 100, // Amount in paisa
                    'currency' => 'INR',
                    'payment_capture' => 1
                ];

                $razorpayOrder = $razorpay->order->create($razorpayOrderData);
                $razorpayOrderId = $razorpayOrder->id;

                \Log::info('Razorpay order created for checkout (no DB order created)', [
                    'razorpay_order_id' => $razorpayOrderId,
                    'amount' => $totalAmount,
                    'user_id' => $userId
                ]);

                // Store checkout data in session for later use after payment
                session([
                    'checkout_data' => [
                        'user_id' => $userId,
                        'guest_user_id' => $guestId,
                        'ip_address' => $ipAddress,
                        'cart_items' => $cartItems->toArray(),
                        'cart_total' => $cartTotal,
                        'shipping_cost' => $shippingCost,
                        'total_amount' => $totalAmount,
                        'form_data' => $request->all(),
                        'razorpay_order_id' => $razorpayOrderId,
                        'created_at' => now()
                    ]
                ]);

                return response()->json([
                    'razorpay_order_id' => $razorpayOrderId,
                    'amount' => $totalAmount,
                    'checkout_session_id' => session()->getId()
                ]);

            } catch (\Exception $e) {
                \Log::error('Razorpay order creation failed', [
                    'error' => $e->getMessage(),
                    'user_id' => $userId
                ]);
                return response()->json(['error' => 'Failed to initialize payment'], 500);
            }
        }

        // For COD payments, create order immediately (since no payment verification needed)
        if ($paymentMethod === 'cod') {
            return $this->processCodOrder($request, $userId, $ipAddress, $cartItems, $cartTotal, $shippingCost, $totalAmount);
        }

        return response()->json(['error' => 'Invalid payment method'], 400);
    }

    /**
     * Get client IP address (kept for logging purposes)
     */
    private function getClientIp()
    {
        $ip = request()->ip();
        // For local development, ensure we use 127.0.0.1
        if ($ip === '::1' || $ip === '127.0.0.1') {
            return '127.0.0.1';
        }
        return $ip;
    }

    /**
     * Save order full details for persistent order history
     */
    private function saveOrderFullDetails($order, $cartItems, $products, $variants, $request, $billingAddressFormatted, $shippingAddressFormatted, $cartTotal, $shippingCost, $totalAmount, $paymentMethod, $paymentStatus)
    {
        \Log::info('saveOrderFullDetails called', [
            'order_id' => $order->order_id,
            'cart_items_count' => $cartItems->count(),
            'products_count' => $products->count(),
            'variants_count' => $variants->count()
        ]);

        try {
            // Get user info
            $user = $order->user;
            $userEmail = $user ? $user->email : $request->email;
            $userName = $user ? $user->name : ($request->first_name . ' ' . $request->last_name);
            $userPhone = $user ? $user->phone_number : $request->phone;

            \Log::info('User info gathered', [
                'user_email' => $userEmail,
                'user_name' => $userName,
                'user_phone' => $userPhone
            ]);

            foreach ($cartItems as $cartItem) {
                // Handle both object and array formats for cart items
                $cartItemId = is_array($cartItem) ? ($cartItem['id'] ?? null) : ($cartItem->id ?? null);
                $cartProductId = is_array($cartItem) ? ($cartItem['product_id'] ?? null) : ($cartItem->product_id ?? null);
                $cartVariantId = is_array($cartItem) ? ($cartItem['product_varient_id'] ?? null) : ($cartItem->product_varient_id ?? null);
                $cartQuantity = is_array($cartItem) ? ($cartItem['product_quantity'] ?? null) : ($cartItem->product_quantity ?? null);
                $cartPrice = is_array($cartItem) ? ($cartItem['price'] ?? null) : ($cartItem->price ?? null);
                $cartSize = is_array($cartItem) ? ($cartItem['product_size'] ?? null) : ($cartItem->product_size ?? null);
                $cartColor = is_array($cartItem) ? ($cartItem['product_color'] ?? null) : ($cartItem->product_color ?? null);
                $cartProductName = is_array($cartItem) ? ($cartItem['product_name'] ?? null) : ($cartItem->product_name ?? null);
                $cartProductImage = is_array($cartItem) ? ($cartItem['product_image'] ?? null) : ($cartItem->product_image ?? null);

                \Log::info('Processing cart item', [
                    'cart_item_id' => $cartItemId,
                    'product_id' => $cartProductId,
                    'variant_id' => $cartVariantId,
                    'quantity' => $cartQuantity
                ]);

                // If product_id is null but we have a variant, get product_id from variant
                if (!$cartProductId && $cartVariantId) {
                    $variant = $variants->get($cartVariantId);
                    if ($variant && $variant->product_id) {
                        $cartProductId = $variant->product_id;
                        \Log::info('Using product_id from variant', ['product_id' => $cartProductId]);
                    }
                }

                // Get product and variant details
                $product = $products->get($cartProductId);
                $variant = $cartVariantId ? $variants->get($cartVariantId) : null;

                if (!$product) {
                    \Log::warning('Product not found, skipping', ['product_id' => $cartProductId]);
                    continue; // Skip if product not found
                }

                \Log::info('Product found', [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'category_id' => $product->category_id
                ]);

                // Get category info
                $category = null;
                if ($product->category_id) {
                    try {
                        $category = \App\Models\Category::find($product->category_id);
                        \Log::info('Category lookup', [
                            'category_id' => $product->category_id,
                            'category_found' => $category ? true : false
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Error finding category', [
                            'category_id' => $product->category_id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Calculate pricing
                $unitPrice = $cartPrice ?? $product->product_price;
                $productTotal = $unitPrice * $cartQuantity;

                \App\Models\OrderFullDetail::create([
                    'order_id' => $order->id,
                    'order_number' => $order->order_id,
                    'user_id' => $order->user_id,
                    'user_email' => $userEmail,
                    'user_name' => $userName,
                    'user_phone' => $userPhone,
                    'product_id' => $cartProductId,
                    'product_name' => $product->product_name,
                    'product_description' => $product->product_description,
                    'product_specification' => $product->product_specification,
                    'product_image' => $product->product_image,
                    'product_slug' => $product->product_slug,
                    'category_id' => $product->category_id,
                    'category_name' => $category ? $category->name : null,
                    'variant_id' => $cartVariantId,
                    'variant_name' => $variant ? $variant->variant_name : null,
                    'variant_image' => $variant ? $variant->variant_image : null,
                    'variant_slug' => $variant ? $variant->variant_slug : null,
                    'variant_value' => $variant ? $variant->variant_value : null,
                    'variant_size_value' => $cartSize,
                    'variant_offer_price' => $variant ? $variant->variant_price : $product->product_price,
                    'variant_mrp_price' => $variant ? $variant->variant_mrp_price : $product->product_mrp_price,
                    'variant_quantity' => $variant ? $variant->variant_quantity : $product->product_quantity,
                    'order_quantity' => $cartQuantity,
                    'order_unit_price' => $unitPrice,
                    'order_total_price' => $productTotal,
                    'order_subtotal' => $cartTotal,
                    'order_gst_amount' => 0, // Can be calculated if needed
                    'order_delivery_charge' => $shippingCost,
                    'order_discount_amount' => 0,
                    'order_grand_total' => $totalAmount,
                    'order_status' => $order->delivery_status,
                    'payment_method' => $paymentMethod,
                    'payment_status' => $paymentStatus == 1 ? 'completed' : 'pending',
                    'shipping_address' => json_encode($this->parseAddress($shippingAddressFormatted)),
                    'billing_address' => json_encode($this->parseAddress($billingAddressFormatted)),
                    'order_created_at' => $order->date_ordered_on,
                ]);
            }

            \Log::info('Order full details saved successfully', ['order_id' => $order->order_id]);

        } catch (\Exception $e) {
            \Log::error('Failed to save order full details', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Don't fail the order if saving full details fails
        }
    }

    /**
     * Process COD order (create immediately since no payment verification needed)
     */
    private function processCodOrder($request, $userId, $ipAddress, $cartItems, $cartTotal, $shippingCost, $totalAmount)
    {
        DB::beginTransaction();
        try {
            // Handle guest user creation/finding for address storage
            $guestUserId = null;
            $isGuest = !$userId;

            if ($isGuest) {
                // For guest users, use IP address as the identifier (stored in user_id field)
                $guestUserId = $ipAddress;

                // Optionally create/update guest user record in users table
                $emailExists = User::where('email', $request->email)->exists();
                $phoneExists = User::where('phone_number', $request->phone)->exists();
                if (!$emailExists && !$phoneExists) {
                    $guestUser = User::where('user_id', $ipAddress)->where('is_guest_user', 1)->first();
                    if (!$guestUser) {
                        User::create([
                            'user_id' => $ipAddress,
                            'is_guest_user' => 1,
                            'name' => $request->first_name . ' ' . $request->last_name,
                            'email' => $request->email,
                            'phone_number' => $request->phone,
                            'password' => null, // No password for guests
                        ]);
                    }
                }
            }

            // Save billing address to user_addresses table
            $billingAddress = UserAddress::create([
                'address_username' => $request->first_name . ' ' . $request->last_name,
                'address_first_name' => $request->first_name,
                'address_last_name' => $request->last_name,
                'user_id' => $userId,
                'guest_user_id' => $guestUserId,
                'address_line_one' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->zip_code,
                'district' => $request->city, // Using city as district
                'address_phone_number' => $request->phone,
                'address_type_id' => 1, // 1 = Home/Billing
                'address_type_name' => 'Home',
            ]);

            // Save shipping address to user_addresses table (if different)
            $shippingAddress = null;
            if ($request->shipping_first_name && $request->shipping_address) {
                // Different shipping address provided
                $shippingAddress = UserAddress::create([
                    'address_username' => $request->shipping_first_name . ' ' . $request->shipping_last_name,
                    'address_first_name' => $request->shipping_first_name,
                    'address_last_name' => $request->shipping_last_name,
                    'user_id' => $userId,
                    'guest_user_id' => $guestUserId,
                    'address_line_one' => $request->shipping_address,
                    'city' => $request->shipping_city,
                    'state' => $request->shipping_state,
                    'pincode' => $request->shipping_zip_code,
                    'district' => $request->shipping_city, // Using city as district
                    'address_phone_number' => $request->phone, // Using billing phone
                    'address_type_id' => 2, // 2 = Work/Shipping
                    'address_type_name' => 'Work',
                ]);
            }

            // Create formatted address strings for backward compatibility (session storage)
            $billingAddressFormatted = $request->first_name . ' ' . $request->last_name . "\n" .
                                     $request->address . "\n" .
                                     $request->city . ', ' . $request->state . ' ' . $request->zip_code . "\n" .
                                     $request->country . "\n" .
                                     'Phone: ' . $request->phone . "\n" .
                                     'Email: ' . $request->email;

            $shippingAddressFormatted = $request->shipping_first_name && $request->shipping_address
                ? $request->shipping_first_name . ' ' . $request->shipping_last_name . "\n" .
                  $request->shipping_address . "\n" .
                  $request->shipping_city . ', ' . $request->shipping_state . ' ' . $request->shipping_zip_code . "\n" .
                  $request->shipping_country
                : $billingAddressFormatted;

            // Create order with COD payment status = 1 (paid)
            $order = Order::create([
                'user_id' => $userId,
                'order_id' => Order::generateNextOrderId(),
                'order_name' => $request->first_name . ' ' . $request->last_name,
                'total_amount' => $cartTotal,
                'gst_amount' => 0,
                'discount_amount' => 0,
                'delivery_charge' => $shippingCost,
                'grand_total_amount' => $totalAmount,
                'payment_status' => 1, // COD is considered paid
                'delivery_status' => 0,
                'order_notes' => $request->order_notes,
                'payment_method' => 'cod',
            ]);

            // Save addresses to product_order_user_addresses table
            $this->saveOrderAddresses($order->order_id, $request, $userId, $guestUserId);

            // Store addresses in session
            session([
                'order_' . $order->order_id . '_billing' => $billingAddress,
                'order_' . $order->order_id . '_shipping' => $shippingAddress,
                'order_' . $order->order_id . '_customer' => [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]
            ]);

            // Load products and variants for order processing
            $productIds = $cartItems->pluck('product_id')->unique()->filter();
            $variantIds = $cartItems->pluck('product_varient_id')->unique()->filter();

            if ($variantIds->isNotEmpty()) {
                $variantsForProducts = ProductVariant::whereIn('id', $variantIds)
                    ->whereNotNull('product_id')
                    ->pluck('product_id', 'id');

                foreach ($variantsForProducts as $variantId => $productId) {
                    if ($productId && !$productIds->contains($productId)) {
                        $productIds->push($productId);
                    }
                }
            }

            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
            $variants = $variantIds->isNotEmpty()
                ? ProductVariant::whereIn('id', $variantIds)->get()->keyBy('id')
                : collect();

            // Save order items
            foreach ($cartItems as $cartItem) {
                $cartProductId = $cartItem->product_id;
                if (!$cartProductId && $cartItem->product_varient_id) {
                    $variant = $variants->get($cartItem->product_varient_id);
                    if ($variant && $variant->product_id) {
                        $cartProductId = $variant->product_id;
                    }
                }

                $product = $products->get($cartProductId);
                $variant = $cartItem->product_varient_id ? $variants->get($cartItem->product_varient_id) : null;

                $unitPrice = $cartItem->price ?? $product->product_price;
                $productTotal = $unitPrice * $cartItem->product_quantity;

                ProductSlot::create([
                    'delivery_date' => null,
                    'order_id' => $order->order_id,
                    'product_id' => $cartProductId,
                    'product_varient_id' => $cartItem->product_varient_id,
                    'product_name' => $cartItem->product_name ?? $product->product_name,
                    'order_name' => $request->first_name . ' ' . $request->last_name,
                    'product_image' => $cartItem->product_image ?? $product->product_image,
                    'product_rate' => $unitPrice,
                    'gst_amt' => 0,
                    'gst_per' => $product->gst ?? 0,
                    'product_value' => $productTotal,
                    'quantity' => $cartItem->product_quantity,
                    'product_total' => $productTotal,
                    'shipping' => $shippingCost / $cartItems->count(),
                    'discount' => 0,
                    'size_value' => $cartItem->product_size,
                    'color_value' => $cartItem->product_color,
                    'delivery_status' => 0,
                    'preorder' => 0,
                    'dispatch_date' => null,
                    'order_delivered_time' => null,
                    'deliver_person_id' => null,
                    'is_cancelled' => 0,
                    'cancel_reason' => null,
                    'approve_staus' => 1,
                ]);
            }

            // Deduct stock for COD orders
            foreach ($cartItems as $cartItem) {
                $cartProductId = $cartItem->product_id;
                if (!$cartProductId && $cartItem->product_varient_id) {
                    $variant = $variants->get($cartItem->product_varient_id);
                    if ($variant && $variant->product_id) {
                        $cartProductId = $variant->product_id;
                    }
                }

                if ($cartItem->product_varient_id) {
                    $variant = $variants->get($cartItem->product_varient_id);
                    if ($variant) {
                        $variant->decrement('product_qty', $cartItem->product_quantity);
                    }
                } else {
                    $product = $products->get($cartProductId);
                    if ($product) {
                        $product->decrement('product_quantity', $cartItem->product_quantity);
                    }
                }

                $productStock = \App\Models\ProductStock::findByProductVariant(
                    $cartProductId,
                    $cartItem->product_varient_id
                );

                if ($productStock) {
                    $productStock->reduceStock($cartItem->product_quantity);
                }
            }

            // Handle guest user creation for COD
            $notificationUserId = $userId;
            if ($isGuest) {
                $emailExists = User::where('email', $request->email)->exists();
                if (!$emailExists) {
                    $user = User::create([
                        'name' => $request->first_name . ' ' . $request->last_name,
                        'email' => $request->email,
                        'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                        'phone_number' => $request->phone,
                        'address' => $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip_code . ', ' . $request->country,
                        'mobile' => $request->phone,
                        'user_type' => 'user',
                        'ip_address' => $ipAddress,
                    ]);

                    Cart::transferGuestCart($ipAddress, $user->id);
                    $order->update(['user_id' => $user->id]);
                    $notificationUserId = $user->id;
                }
            }

            DB::commit();

            // Save order full details
            $this->saveOrderFullDetails($order, $cartItems, $products, $variants, $request, $billingAddressFormatted, $shippingAddressFormatted, $cartTotal, $shippingCost, $totalAmount, 'cod', 1);

            // Clear cart
            $cartClearUserId = $notificationUserId ?: $userId;
            $query = Cart::query();
            if ($cartClearUserId) {
                $query->where('user_id', $cartClearUserId);
            } elseif ($ipAddress) {
                $query->where('ip_address', $ipAddress)->whereNull('user_id');
            }
            $query->delete();

            // Send notifications
            try {
                \App\Jobs\SendOrderNotifications::dispatch(
                    $order,
                    $notificationUserId,
                    $isGuest,
                    $request->force_guest_checkout ?? false,
                    $request->email
                );
            } catch (\Exception $e) {
                \Log::error('Notification dispatch error', ['error' => $e->getMessage()]);
            }

            // Create Shiprocket order
            try {
                $shiprocket = new ShiprocketService();
                // Get selected courier ID from request if provided
                $selectedCourierId = $request->input('selected_courier_id') ? (int) $request->input('selected_courier_id') : null;
                $shiprocketResult = $shiprocket->createOrder($order, $selectedCourierId);
                
                if ($shiprocketResult['success']) {
                    \Log::info('Shiprocket order created for COD order', [
                        'order_id' => $order->order_id,
                        'shiprocket_order_id' => $shiprocketResult['shiprocket_order_id'] ?? null,
                        'awb_code' => $shiprocketResult['awb_code'] ?? null
                    ]);
                } else {
                    \Log::warning('Shiprocket order creation failed for COD order', [
                        'order_id' => $order->order_id,
                        'error' => $shiprocketResult['message'] ?? 'Unknown error'
                    ]);
                }

                // Sync to product_tracking table for Dashboard
                if ($shiprocketResult['success']) {
                    ProductTracking::syncFromOrder($order->fresh());
                }
            } catch (\Exception $e) {
                \Log::error('Shiprocket order creation exception', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage()
                ]);
                // Don't fail the order if Shiprocket fails
            }

            return redirect()->route('checkout')->with('order_success', true)->with('order_number', $order->order_id);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('COD order error', ['error' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'Failed to process order. Please try again.');
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $checkoutData = session('checkout_data');
        if (!$checkoutData) {
            \Log::error('No checkout data found in session');
            return response()->json(['error' => 'Session expired. Please try again.'], 400);
        }

        if (!$this->verifyRazorpayPayment($request)) {
            return response()->json(['error' => 'Payment verification failed'], 400);
        }

        DB::beginTransaction();
        try {
            $orderData = $this->processOrderCreation($request, $checkoutData);
            DB::commit();

            $this->handlePostOrderTasks($orderData['order'], $orderData['notification_user_id'], $orderData['is_guest'], $orderData['form_data'], $checkoutData);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderData['order']->order_id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Payment success order creation failed', [
                'error' => $e->getMessage(),
                'razorpay_order_id' => $request->razorpay_order_id
            ]);
            return response()->json(['error' => 'Failed to process order'], 500);
        }
    }

    private function verifyRazorpayPayment(Request $request): bool
    {
        try {
            $razorpay = new \Razorpay\Api\Api(
                config('services.razorpay.key_id'),
                config('services.razorpay.key_secret')
            );

            $razorpay->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            \Log::info('Payment signature verified', [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id
            ]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Payment verification failed', [
                'error' => $e->getMessage(),
                'razorpay_order_id' => $request->razorpay_order_id
            ]);
            return false;
        }
    }

    private function processOrderCreation(Request $request, array $checkoutData): array
    {
        $userId = $checkoutData['user_id'];
        $ipAddress = $checkoutData['ip_address'];
        $cartItems = collect($checkoutData['cart_items']);
        $formData = $checkoutData['form_data'];
        $isGuest = !$userId;

        $guestUserId = $this->createGuestUserIfNeeded($isGuest, $ipAddress, $formData);
        $addresses = $this->createUserAddresses($userId, $guestUserId, $formData);
        $order = $this->createOrderRecord($request, $checkoutData, $userId, $formData);
        
        $this->saveOrderAddresses($order->order_id, (object)$formData, $userId, $guestUserId);
        $this->storeAddressesInSession($order->order_id, $addresses, $formData);

        $collections = $this->loadProductsAndVariants($cartItems);
        $this->saveOrderItems($order, $cartItems, $collections, $formData, $checkoutData['shipping_cost']);
        $this->deductStock($cartItems, $collections);

        $notificationUserId = $this->createPermanentUserIfGuest($isGuest, $userId, $ipAddress, $formData, $order);
        $this->saveOrderFullDetailsWrapper($order, $cartItems, $collections, $formData, $checkoutData);
        $this->clearCart($notificationUserId ?: $userId, $ipAddress);

        session()->forget('checkout_data');

        return [
            'order' => $order,
            'notification_user_id' => $notificationUserId,
            'is_guest' => $isGuest,
            'form_data' => $formData
        ];
    }

    private function createGuestUserIfNeeded(bool $isGuest, ?string $ipAddress, array $formData): ?string
    {
        if (!$isGuest) {
            return null;
        }

        $guestUserId = $ipAddress;
        $emailExists = User::where('email', $formData['email'])->exists();
        $phoneExists = User::where('phone_number', $formData['phone'])->exists();
        
        if (!$emailExists && !$phoneExists) {
            $guestUser = User::where('user_id', $ipAddress)->where('is_guest_user', 1)->first();
            if (!$guestUser) {
                User::create([
                    'user_id' => $ipAddress,
                    'is_guest_user' => 1,
                    'name' => $formData['first_name'] . ' ' . $formData['last_name'],
                    'email' => $formData['email'],
                    'phone_number' => $formData['phone'],
                    'password' => null,
                ]);
            }
        }
        
        return $guestUserId;
    }

    private function createUserAddresses(?int $userId, ?string $guestUserId, array $formData): array
    {
        $billingAddress = UserAddress::create([
            'address_username' => $formData['first_name'] . ' ' . $formData['last_name'],
            'address_first_name' => $formData['first_name'],
            'address_last_name' => $formData['last_name'],
            'user_id' => $userId,
            'guest_user_id' => $guestUserId,
            'address_line_one' => $formData['address'],
            'city' => $formData['city'],
            'state' => $formData['state'],
            'pincode' => $formData['zip_code'],
            'district' => $formData['city'],
            'address_phone_number' => $formData['phone'],
            'address_type_id' => 1,
            'address_type_name' => 'Home',
        ]);

        $shippingAddress = null;
        if (isset($formData['shipping_first_name']) && isset($formData['shipping_address'])) {
            $shippingAddress = UserAddress::create([
                'address_username' => $formData['shipping_first_name'] . ' ' . $formData['shipping_last_name'],
                'address_first_name' => $formData['shipping_first_name'],
                'address_last_name' => $formData['shipping_last_name'],
                'user_id' => $userId,
                'guest_user_id' => $guestUserId,
                'address_line_one' => $formData['shipping_address'],
                'city' => $formData['shipping_city'],
                'state' => $formData['shipping_state'],
                'pincode' => $formData['shipping_zip_code'],
                'district' => $formData['shipping_city'],
                'address_phone_number' => $formData['phone'],
                'address_type_id' => 2,
                'address_type_name' => 'Work',
            ]);
        }

        return ['billing' => $billingAddress, 'shipping' => $shippingAddress];
    }

    private function createOrderRecord(Request $request, array $checkoutData, ?int $userId, array $formData): Order
    {
        return Order::create([
            'user_id' => $userId,
            'order_id' => Order::generateNextOrderId(),
            'order_name' => $formData['first_name'] . ' ' . $formData['last_name'],
            'total_amount' => $checkoutData['cart_total'],
            'gst_amount' => 0,
            'discount_amount' => 0,
            'delivery_charge' => $checkoutData['shipping_cost'],
            'grand_total_amount' => $checkoutData['total_amount'],
            'payment_status' => 1,
            'delivery_status' => 0,
            'order_notes' => $formData['order_notes'] ?? null,
            'payment_method' => 'razorpay',
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
        ]);
    }

    private function storeAddressesInSession(string $orderId, array $addresses, array $formData): void
    {
        session([
            'order_' . $orderId . '_billing' => $addresses['billing'],
            'order_' . $orderId . '_shipping' => $addresses['shipping'],
            'order_' . $orderId . '_customer' => [
                'name' => $formData['first_name'] . ' ' . $formData['last_name'],
                'email' => $formData['email'],
                'phone' => $formData['phone']
            ]
        ]);
    }

    private function loadProductsAndVariants($cartItems): array
    {
        $productIds = $cartItems->pluck('product_id')->unique()->filter();
        $variantIds = $cartItems->pluck('product_varient_id')->unique()->filter();

        if ($variantIds->isNotEmpty()) {
            $variantsForProducts = ProductVariant::whereIn('id', $variantIds)
                ->whereNotNull('product_id')
                ->pluck('product_id', 'id');

            foreach ($variantsForProducts as $variantId => $productId) {
                if ($productId && !$productIds->contains($productId)) {
                    $productIds->push($productId);
                }
            }
        }

        return [
            'products' => Product::whereIn('id', $productIds)->get()->keyBy('id'),
            'variants' => $variantIds->isNotEmpty() 
                ? ProductVariant::whereIn('id', $variantIds)->get()->keyBy('id')
                : collect()
        ];
    }

    private function saveOrderItems(Order $order, $cartItems, array $collections, array $formData, float $shippingCost): void
    {
        $products = $collections['products'];
        $variants = $collections['variants'];

        foreach ($cartItems as $cartItem) {
            $cartProductId = $this->resolveProductId($cartItem, $variants);
            $product = $products->get($cartProductId);
            $unitPrice = $cartItem['price'] ?? $product->product_price;

            ProductSlot::create([
                'delivery_date' => null,
                'order_id' => $order->order_id,
                'product_id' => $cartProductId,
                'product_varient_id' => $cartItem['product_varient_id'],
                'product_name' => $cartItem['product_name'] ?? $product->product_name,
                'order_name' => $formData['first_name'] . ' ' . $formData['last_name'],
                'product_image' => $cartItem['product_image'] ?? $product->product_image,
                'product_rate' => $unitPrice,
                'gst_amt' => 0,
                'gst_per' => $product->gst ?? 0,
                'product_value' => $unitPrice * $cartItem['product_quantity'],
                'quantity' => $cartItem['product_quantity'],
                'product_total' => $unitPrice * $cartItem['product_quantity'],
                'shipping' => $shippingCost / $cartItems->count(),
                'discount' => 0,
                'size_value' => $cartItem['product_size'],
                'color_value' => $cartItem['product_color'],
                'delivery_status' => 0,
                'preorder' => 0,
                'dispatch_date' => null,
                'order_delivered_time' => null,
                'deliver_person_id' => null,
                'is_cancelled' => 0,
                'cancel_reason' => null,
                'approve_staus' => 1,
            ]);
        }
    }

    private function deductStock($cartItems, array $collections): void
    {
        $products = $collections['products'];
        $variants = $collections['variants'];

        foreach ($cartItems as $cartItem) {
            $cartProductId = $this->resolveProductId($cartItem, $variants);

            if ($cartItem['product_varient_id']) {
                $variant = $variants->get($cartItem['product_varient_id']);
                if ($variant) {
                    $variant->decrement('product_qty', $cartItem['product_quantity']);
                }
            } else {
                $product = $products->get($cartProductId);
                if ($product) {
                    $product->decrement('product_quantity', $cartItem['product_quantity']);
                }
            }

            $productStock = \App\Models\ProductStock::findByProductVariant(
                $cartProductId,
                $cartItem['product_varient_id']
            );

            if ($productStock) {
                $productStock->reduceStock($cartItem['product_quantity']);
            }
        }
    }

    private function resolveProductId(array $cartItem, $variants): ?int
    {
        $cartProductId = $cartItem['product_id'];
        if (!$cartProductId && $cartItem['product_varient_id']) {
            $variant = $variants->get($cartItem['product_varient_id']);
            if ($variant && $variant->product_id) {
                $cartProductId = $variant->product_id;
            }
        }
        return $cartProductId;
    }

    private function createPermanentUserIfGuest(bool $isGuest, ?int $userId, ?string $ipAddress, array $formData, Order $order): ?int
    {
        if (!$isGuest) {
            return $userId;
        }

        $emailExists = User::where('email', $formData['email'])->exists();
        if (!$emailExists) {
            $user = User::create([
                'name' => $formData['first_name'] . ' ' . $formData['last_name'],
                'email' => $formData['email'],
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                'phone_number' => $formData['phone'],
                'address' => $formData['address'] . ', ' . $formData['city'] . ', ' . $formData['state'] . ' ' . $formData['zip_code'] . ', ' . $formData['country'],
                'mobile' => $formData['phone'],
                'user_type' => 'user',
                'ip_address' => $ipAddress,
            ]);

            Cart::transferGuestCart($ipAddress, $user->id);
            $order->update(['user_id' => $user->id]);
            return $user->id;
        }

        return $userId;
    }

    private function saveOrderFullDetailsWrapper(Order $order, $cartItems, array $collections, array $formData, array $checkoutData): void
    {
        $billingAddressFormatted = $formData['first_name'] . ' ' . $formData['last_name'] . "\n" .
                                 $formData['address'] . "\n" .
                                 $formData['city'] . ', ' . $formData['state'] . ' ' . $formData['zip_code'] . "\n" .
                                 ($formData['country'] ?? 'India') . "\n" .
                                 'Phone: ' . $formData['phone'] . "\n" .
                                 'Email: ' . $formData['email'];

        $shippingAddressFormatted = (isset($formData['shipping_first_name']) && isset($formData['shipping_address']))
            ? $formData['shipping_first_name'] . ' ' . $formData['shipping_last_name'] . "\n" .
              $formData['shipping_address'] . "\n" .
              $formData['shipping_city'] . ', ' . $formData['shipping_state'] . ' ' . $formData['shipping_zip_code'] . "\n" .
              ($formData['shipping_country'] ?? 'India')
            : $billingAddressFormatted;

        $this->saveOrderFullDetails(
            $order, 
            $cartItems, 
            $collections['products'], 
            $collections['variants'], 
            (object)$formData, 
            $billingAddressFormatted, 
            $shippingAddressFormatted, 
            $checkoutData['cart_total'], 
            $checkoutData['shipping_cost'], 
            $checkoutData['total_amount'], 
            'razorpay', 
            1
        );
    }

    private function clearCart(?int $userId, ?string $ipAddress): void
    {
        $query = Cart::query();
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($ipAddress) {
            $query->where('ip_address', $ipAddress)->whereNull('user_id');
        }
        $query->delete();
    }

    private function handlePostOrderTasks(Order $order, ?int $notificationUserId, bool $isGuest, array $formData, array $checkoutData): void
    {
        try {
            \App\Jobs\SendOrderNotifications::dispatch(
                $order,
                $notificationUserId,
                $isGuest,
                $formData['force_guest_checkout'] ?? false,
                $formData['email']
            );
        } catch (\Exception $e) {
            \Log::error('Notification dispatch error', ['error' => $e->getMessage()]);
        }

        $this->processShiprocketOrder($order, $checkoutData);
    }

    private function processShiprocketOrder(Order $order, array $checkoutData): void
    {
        try {
            $shiprocket = new ShiprocketService();
            $selectedCourierId = isset($checkoutData['form_data']['selected_courier_id']) 
                ? (int) $checkoutData['form_data']['selected_courier_id'] 
                : null;
            $shiprocketResult = $shiprocket->createOrder($order, $selectedCourierId);
            
            if ($shiprocketResult['success'] && !empty($shiprocketResult['awb_code'])) {
                \Log::info('Shiprocket order created and AWB generated', [
                    'order_id' => $order->order_id,
                    'shiprocket_order_id' => $shiprocketResult['shiprocket_order_id'] ?? null,
                    'awb_code' => $shiprocketResult['awb_code'] ?? null
                ]);
                ProductTracking::syncFromOrder($order->fresh());
            } else {
                $this->handleShiprocketFailure($order, $shiprocket, $shiprocketResult);
            }
        } catch (\Exception $e) {
            \Log::error('Shiprocket order creation exception', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function handleShiprocketFailure(Order $order, ShiprocketService $shiprocket, array $shiprocketResult): void
    {
        $errorMessage = $shiprocketResult['message'] ?? 'Unknown error';
        
        // Check if order was created successfully in Shiprocket but only AWB failed
        $shiprocketOrderCreated = isset($shiprocketResult['shiprocket_order_id']) && $shiprocketResult['success'];
        
        if ($shiprocketOrderCreated) {
            // Order exists in Shiprocket - DON'T cancel, just flag for manual AWB assignment
            \Log::warning('AWB generation pending - Order created successfully, AWB will be assigned manually', [
                'order_id' => $order->order_id,
                'shiprocket_order_id' => $shiprocketResult['shiprocket_order_id'],
                'shipment_id' => $shiprocketResult['shipment_id'] ?? null,
                'awb_error' => $shiprocketResult['awb_error'] ?? $errorMessage
            ]);

            $notes = ($order->order_notes ? $order->order_notes . "\n" : "") . 
                     "Note: AWB generation pending. Shiprocket Order #{$shiprocketResult['shiprocket_order_id']} created successfully. " .
                     "Admin can assign AWB manually from Shiprocket dashboard. " .
                     "AWB Error: " . ($shiprocketResult['awb_error'] ?? $errorMessage);

            // Update order with Shiprocket IDs but set status to "Pending AWB" (status 6) instead of "Shipping Lock Failed" (status 5)
            // Status 6 = Pending AWB - allows admin to manually process
            $order->update([
                'delivery_status' => 0, // Pending AWB - less severe than status 5
                'order_notes' => $notes
            ]);
            
            // Sync to tracking - order is still valid, just needs manual AWB
            ProductTracking::syncFromOrder($order->fresh());
            
        } else {
            // Shiprocket order creation itself failed
            \Log::critical('Shiprocket order creation failed completely', [
                'order_id' => $order->order_id,
                'error' => $errorMessage
            ]);

            $notes = ($order->order_notes ? $order->order_notes . "\n" : "") . 
                     "CRITICAL: Shiprocket order creation failed. Error: " . $errorMessage .
                     "\nAdmin action required - please create shipment manually.";

            $order->update([
                'delivery_status' => 0, // Status 5: Shipping Lock Failed - requires attention
                'order_notes' => $notes
            ]);
        }
    }

    /**
     * Save addresses to product_order_user_addresses table
     */
    private function saveOrderAddresses($orderId, $request, $userId, $guestUserId)
    {
        // Save billing address to product_order_user_addresses
        ProductOrderUserAddress::create([
            'user_id' => $userId,
            'guest_user_id' => $guestUserId,
            'order_id' => $orderId,
            'address_line_one' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->zip_code,
            'address_phone_number' => $request->phone,
            'address_type_id' => 1, // 1 = Home/Billing
            'address_type_name' => 'Home',
        ]);

        // Save shipping address if different
        if ($request->shipping_first_name && $request->shipping_address) {
            ProductOrderUserAddress::create([
                'user_id' => $userId,
                'guest_user_id' => $guestUserId,
                'order_id' => $orderId,
                'address_line_one' => $request->shipping_address,
                'city' => $request->shipping_city,
                'state' => $request->shipping_state,
                'pincode' => $request->shipping_zip_code,
                'address_phone_number' => $request->phone, // Use billing phone
                'address_type_id' => 2, // 2 = Work/Shipping
                'address_type_name' => 'Work',
            ]);
        }
    }

    /**
     * Parse address string into array format
     */
    private function parseAddress($addressString)
    {
        $lines = explode("\n", trim($addressString));
        $address = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            if (strpos($line, 'Phone:') === 0) {
                $address['phone'] = trim(str_replace('Phone:', '', $line));
            } elseif (strpos($line, 'Email:') === 0) {
                $address['email'] = trim(str_replace('Email:', '', $line));
            } else {
                // Parse name and address parts
                if (!isset($address['firstname'])) {
                    $nameParts = explode(' ', $line, 2);
                    $address['firstname'] = $nameParts[0] ?? '';
                    $address['lastname'] = $nameParts[1] ?? '';
                } elseif (!isset($address['address_line_one'])) {
                    $address['address_line_one'] = $line;
                } elseif (!isset($address['city'])) {
                    // Parse city, state, pincode
                    $parts = explode(',', $line);
                    $address['city'] = trim($parts[0] ?? '');
                    if (isset($parts[1])) {
                        $statePin = explode(' ', trim($parts[1]), 2);
                        $address['state'] = trim($statePin[0] ?? '');
                        $address['pincode'] = trim($statePin[1] ?? '');
                    }
                } elseif (!isset($address['country'])) {
                    $address['country'] = $line;
                }
            }
        }

        return $address;
    }
}
