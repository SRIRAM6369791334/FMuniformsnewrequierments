<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\ProductSlot;
use App\Models\ProductOrderUserAddress;

class ShiprocketService
{
    protected $baseUrl;
    protected $email;
    protected $password;
    protected $pickupLocation;
    protected $channelId;

    public function __construct()
    {
        $this->baseUrl = config('services.shiprocket.base_url');
        $this->email = config('services.shiprocket.email');
        $this->password = config('services.shiprocket.password');
        $this->pickupLocation = config('services.shiprocket.pickup_location');
        $this->channelId = config('services.shiprocket.channel_id');
    }

    /**
     * Get authentication token from Shiprocket
     * Token is cached for 9 days (expires in 10 days)
     */
    public function authenticate(): ?string
    {
        $cacheKey = 'shiprocket_token';

        // Check if token is cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::post("{$this->baseUrl}/auth/login", [
                'email' => $this->email,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                $token = $response->json('token');
                
                // Cache token for 9 days (Shiprocket tokens expire in 10 days)
                Cache::put($cacheKey, $token, now()->addDays(9));
                
                Log::info('Shiprocket authentication successful');
                return $token;
            }

            Log::error('Shiprocket authentication failed', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket authentication exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get authenticated HTTP client
     */
    protected function client()
    {
        $token = $this->authenticate();
        
        if (!$token) {
            throw new \Exception('Failed to authenticate with Shiprocket');
        }

        return Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Create order in Shiprocket
     * 
     * @param Order $order The order to create in Shiprocket
     * @param int|null $courierId Optional courier ID to force a specific courier and auto-generate AWB
     * @return array Result with success status and Shiprocket IDs
     */
    public function createOrder(Order $order, ?int $courierId = null): array
    {
        try {
            // Get order items (product slots)
            $orderItems = ProductSlot::where('order_id', $order->order_id)->get();
            
            if ($orderItems->isEmpty()) {
                throw new \Exception('No order items found for order: ' . $order->order_id);
            }

            // Get addresses
            $billingAddress = ProductOrderUserAddress::where('order_id', $order->order_id)
                ->where('address_type_id', 1)
                ->first();
            
            $shippingAddress = ProductOrderUserAddress::where('order_id', $order->order_id)
                ->where('address_type_id', 2)
                ->first();

            // If no separate shipping address, use billing address
            if (!$shippingAddress) {
                $shippingAddress = $billingAddress;
            }

            if (!$billingAddress) {
                throw new \Exception('Billing address not found for order: ' . $order->order_id);
            }

            // Get user info
            $user = $order->user;
            $customerName = $order->order_name ?? ($user ? $user->name : 'Customer');
            $nameParts = explode(' ', $customerName, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            // Get email and phone
            $email = $user ? $user->email : 'customer@example.com';
            $phone = $billingAddress->address_phone_number ?? ($user ? $user->phone_number : '');

            // Prepare order items array
            $shiprocketItems = [];
            foreach ($orderItems as $item) {
                $shiprocketItems[] = [
                    'name' => $item->product_name ?? 'Product',
                    'sku' => ($item->product_id ?? 'PROD') . '-' . ($item->product_varient_id ?? '0'),
                    'units' => (int) $item->quantity,
                    'selling_price' => (float) $item->product_rate,
                    'discount' => (float) ($item->discount ?? 0),
                    'tax' => (float) ($item->gst_amt ?? 0),
                    'hsn' => '',
                ];
            }

            // Calculate package dimensions and weight from actual product data
            $totalItems = $orderItems->sum('quantity');
            $totalWeight = 0;
            
            foreach ($orderItems as $item) {
                $itemWeight = 0;
                
                // Try to get weight from variant first
                if ($item->product_varient_id) {
                    $variant = \App\Models\ProductVariant::find($item->product_varient_id);
                    if ($variant && $variant->weight > 0) {
                        $itemWeight = (float) $variant->weight;
                    }
                }
                
                // Fallback to product weight if variant weight not set
                if ($itemWeight == 0 && $item->product_id) {
                    $product = \App\Models\Product::find($item->product_id);
                    if ($product && $product->weight > 0) {
                        $itemWeight = (float) $product->weight;
                    }
                }
                
                // If still no weight, use default (0.3 kg per item for uniforms)
                if ($itemWeight == 0) {
                    $itemWeight = 0.3;
                }
                
                $totalWeight += $itemWeight * (int) $item->quantity;
            }
            
            // Ensure minimum weight of 0.5 kg
            $weight = max(0.5, $totalWeight);

            // Prepare Shiprocket order data
            $orderData = [
                'order_id' => $order->order_id,
                'order_date' => $order->date_ordered_on 
                    ? $order->date_ordered_on->format('Y-m-d H:i') 
                    : now()->format('Y-m-d H:i'),
                'pickup_location' => $this->pickupLocation,
                'comment' => $order->order_notes ?? '',
                'billing_customer_name' => $firstName,
                'billing_last_name' => $lastName,
                'billing_address' => $billingAddress->address_line_one ?? '',
                'billing_address_2' => $billingAddress->address_line_two ?? '',
                'billing_city' => $billingAddress->city ?? '',
                'billing_pincode' => (string) ($billingAddress->pincode ?? ''),
                'billing_state' => $billingAddress->state ?? '',
                'billing_country' => 'India',
                'billing_email' => $email,
                'billing_phone' => $phone,
                'shipping_is_billing' => $shippingAddress->id === $billingAddress->id,
                'order_items' => $shiprocketItems,
                'payment_method' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
                'shipping_charges' => (float) $order->delivery_charge,
                'giftwrap_charges' => 0,
                'transaction_charges' => 0,
                'total_discount' => (float) $order->discount_amount,
                'sub_total' => (float) $order->total_amount,
                'length' => 25,
                'breadth' => 20,
                'height' => max(5, $totalItems * 3), // 3cm per item
                'weight' => $weight,
            ];

            // Add shipping address if different from billing
            if ($shippingAddress->id !== $billingAddress->id) {
                $shippingName = $shippingAddress->address_username ?? $customerName;
                $shippingNameParts = explode(' ', $shippingName, 2);
                
                $orderData['shipping_customer_name'] = $shippingNameParts[0];
                $orderData['shipping_last_name'] = $shippingNameParts[1] ?? '';
                $orderData['shipping_address'] = $shippingAddress->address_line_one ?? '';
                $orderData['shipping_address_2'] = $shippingAddress->address_line_two ?? '';
                $orderData['shipping_city'] = $shippingAddress->city ?? '';
                
                // Fallback to billing pincode if shipping pincode is missing
                $shippingPincode = (string) ($shippingAddress->pincode ?? '');
                if (empty($shippingPincode)) {
                    $shippingPincode = (string) ($billingAddress->pincode ?? '');
                }
                $orderData['shipping_pincode'] = $shippingPincode;
                
                $orderData['shipping_state'] = $shippingAddress->state ?? '';
                $orderData['shipping_country'] = 'India';
                $orderData['shipping_email'] = $email;
                $orderData['shipping_phone'] = $shippingAddress->address_phone_number ?? $phone;
            }

            // Add channel ID if configured
            if ($this->channelId) {
                $orderData['channel_id'] = $this->channelId;
            }

            Log::info('Creating Shiprocket order', [
                'order_id' => $order->order_id,
                'courier_id' => $courierId,
                'data' => $orderData
            ]);

            $response = $this->client()->post("{$this->baseUrl}/orders/create/adhoc", $orderData);

            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('Shiprocket order created successfully', [
                    'order_id' => $order->order_id,
                    'shiprocket_order_id' => $result['order_id'] ?? null,
                    'shipment_id' => $result['shipment_id'] ?? null,
                ]);

                // Update order with Shiprocket IDs
                $order->update([
                    'shiprocket_order_id' => $result['order_id'] ?? null,
                    'shiprocket_shipping_id' => $result['shipment_id'] ?? null,
                ]);

                $returnData = [
                    'success' => true,
                    'shiprocket_order_id' => $result['order_id'] ?? null,
                    'shipment_id' => $result['shipment_id'] ?? null,
                    'status' => $result['status'] ?? null,
                    'message' => 'Order created successfully in Shiprocket'
                ];

                // If courier ID provided, auto-generate AWB
                if ($courierId && isset($result['shipment_id'])) {
                    Log::info('Auto-generating AWB with selected courier', [
                        'shipment_id' => $result['shipment_id'],
                        'courier_id' => $courierId
                    ]);

                    $awbResult = $this->generateAWB((int) $result['shipment_id'], $courierId);
                    
                    if ($awbResult['success'] && isset($awbResult['awb_code'])) {
                        // Update order with AWB code
                        $order->update([
                            'awb_code' => $awbResult['awb_code']
                        ]);

                        $returnData['awb_code'] = $awbResult['awb_code'];
                        $returnData['courier_name'] = $awbResult['courier_name'] ?? null;
                        $returnData['message'] = 'Order created and AWB generated successfully';

                        Log::info('AWB generated successfully', [
                            'order_id' => $order->order_id,
                            'awb_code' => $awbResult['awb_code']
                        ]);
                    } else {
                        Log::warning('AWB generation failed after order creation', [
                            'order_id' => $order->order_id,
                            'error' => $awbResult['message'] ?? 'Unknown error'
                        ]);
                        $returnData['awb_error'] = $awbResult['message'] ?? 'Failed to generate AWB';
                    }
                }

                return $returnData;
            }

            $error = $response->json();
            Log::error('Shiprocket order creation failed', [
                'order_id' => $order->order_id,
                'status' => $response->status(),
                'response' => $error
            ]);

            return [
                'success' => false,
                'message' => $error['message'] ?? 'Failed to create order in Shiprocket',
                'errors' => $error['errors'] ?? []
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket order creation exception', [
                'order_id' => $order->order_id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    /**
     * Get available courier partners for a shipment
     */
    public function getAvailableCouriers(string $pickupPincode, string $deliveryPincode, float $codAmount = 0, float $weight = 0.5): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/courier/serviceability/", [
                'pickup_postcode' => $pickupPincode,
                'delivery_postcode' => $deliveryPincode,
                'cod' => $codAmount > 0 ? 1 : 0,
                'weight' => $weight,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'couriers' => $response->json('data.available_courier_companies') ?? []
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to fetch couriers',
                'couriers' => []
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket get couriers exception', [
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'couriers' => []
            ];
        }
    }

    /**
     * Generate AWB (Air Waybill) for a shipment
     */
    public function generateAWB(int $shipmentId, ?int $courierId = null): array
    {
        try {
            $data = ['shipment_id' => $shipmentId];
            
            if ($courierId) {
                $data['courier_id'] = $courierId;
            }

            Log::info('Attempting AWB generation', [
                'shipment_id' => $shipmentId,
                'courier_id' => $courierId,
                'request_data' => $data
            ]);

            $response = $this->client()->post("{$this->baseUrl}/courier/assign/awb", $data);
            $result = $response->json();

            Log::info('Shiprocket AWB API Response', [
                'shipment_id' => $shipmentId,
                'status_code' => $response->status(),
                'successful' => $response->successful(),
                'response_body' => $result
            ]);

            if ($response->successful()) {
                // Try multiple possible response structures
                $awbCode = $result['response']['data']['awb_code'] 
                    ?? $result['awb_assign_status'] 
                    ?? $result['data']['awb_code'] 
                    ?? $result['awb_code'] 
                    ?? null;
                    
                $courierName = $result['response']['data']['courier_name'] 
                    ?? $result['courier_name'] 
                    ?? $result['data']['courier_name'] 
                    ?? null;

                // Check if AWB was actually assigned
                if ($awbCode) {
                    return [
                        'success' => true,
                        'awb_code' => $awbCode,
                        'courier_name' => $courierName,
                    ];
                }
                
                // API returned success but no AWB code - check for error in response
                $errorMessage = $result['response']['data']['message'] 
                    ?? $result['message'] 
                    ?? $result['error'] 
                    ?? 'AWB code not found in response';
                    
                Log::warning('AWB generation - No AWB code in successful response', [
                    'shipment_id' => $shipmentId,
                    'response' => $result
                ]);
                
                return [
                    'success' => false,
                    'message' => $errorMessage
                ];
            }

            // Handle non-successful HTTP response
            $errorMessage = $result['message'] ?? $result['error'] ?? 'Failed to generate AWB (HTTP ' . $response->status() . ')';
            
            return [
                'success' => false,
                'message' => $errorMessage
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket AWB generation exception', [
                'shipment_id' => $shipmentId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get tracking details for a shipment
     */
    public function getTracking(string $awbCode): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/courier/track/awb/{$awbCode}");

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'tracking' => $result['tracking_data'] ?? null,
                    'shipment_status' => $result['tracking_data']['shipment_status'] ?? null,
                    'shipment_track' => $result['tracking_data']['shipment_track'] ?? [],
                    'track_activities' => $result['tracking_data']['shipment_track_activities'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to fetch tracking information'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket tracking exception', [
                'awb_code' => $awbCode,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get tracking by order ID
     */
    public function getTrackingByOrderId(string $orderId): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/courier/track", [
                'order_id' => $orderId
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'tracking' => $result ?? null,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to fetch tracking information'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket tracking by order exception', [
                'order_id' => $orderId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Cancel a Shiprocket order
     */
    public function cancelOrder(int $shiprocketOrderId): array
    {
        try {
            $response = $this->client()->post("{$this->baseUrl}/orders/cancel", [
                'ids' => [$shiprocketOrderId]
            ]);

            if ($response->successful()) {
                Log::info('Shiprocket order cancelled', [
                    'shiprocket_order_id' => $shiprocketOrderId
                ]);

                return [
                    'success' => true,
                    'message' => 'Order cancelled successfully'
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to cancel order'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket cancel order exception', [
                'shiprocket_order_id' => $shiprocketOrderId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get order details from Shiprocket
     */
    public function getOrderDetails(int $shiprocketOrderId): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/orders/show/{$shiprocketOrderId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'order' => $response->json('data') ?? null
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to fetch order details'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket get order exception', [
                'shiprocket_order_id' => $shiprocketOrderId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Request shipment pickup
     */
    public function requestPickup(int $shipmentId): array
    {
        try {
            $response = $this->client()->post("{$this->baseUrl}/courier/generate/pickup", [
                'shipment_id' => [$shipmentId]
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Pickup scheduled successfully',
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to schedule pickup'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket pickup request exception', [
                'shipment_id' => $shipmentId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate shipping label
     */
    public function generateLabel(int $shipmentId): array
    {
        try {
            $response = $this->client()->post("{$this->baseUrl}/courier/generate/label", [
                'shipment_id' => [$shipmentId]
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'label_url' => $response->json('label_url') ?? null,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to generate label'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket label generation exception', [
                'shipment_id' => $shipmentId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate invoice
     */
    public function generateInvoice(int $orderId): array
    {
        try {
            $response = $this->client()->post("{$this->baseUrl}/orders/print/invoice", [
                'ids' => [$orderId]
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'invoice_url' => $response->json('invoice_url') ?? null,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to generate invoice'
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket invoice generation exception', [
                'order_id' => $orderId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
