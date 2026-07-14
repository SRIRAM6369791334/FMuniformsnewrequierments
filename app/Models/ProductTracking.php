<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * ProductTracking Model
 * 
 * This model is used to sync Shiprocket data from product_orders to product_tracking table.
 * The Dashboard application reads from this table for Shiprocket operations.
 * 
 * IMPORTANT: Both Website and Dashboard share this table.
 * - Website: Creates/updates records when orders are placed and AWB is generated
 * - Dashboard: Reads and updates for order management, returns, pickups
 */
class ProductTracking extends Model
{
    protected $table = 'product_tracking';

    protected $fillable = [
        'user_id',
        'order_id',
        'delivery_status',
        'status',
        'channel_id',
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'awb_code',
        'tracking_url',
        'delivered_date',
        'return_requested',
        'return_approval_date',
    ];

    protected $casts = [
        'channel_id' => 'integer',
        'return_requested' => 'integer',
    ];

    /**
     * Create or update tracking record from Order data
     * 
     * Called after Shiprocket order creation and AWB generation.
     * Syncs data from product_orders to product_tracking for Dashboard consumption.
     * 
     * @param \App\Models\Order $order The order with Shiprocket data
     * @param string|null $trackingUrl Optional tracking URL
     * @return self|null The tracking record or null on failure
     */
    public static function syncFromOrder($order, ?string $trackingUrl = null): ?self
    {
        try {
            // Only sync if Shiprocket order exists
            if (!$order->shiprocket_order_id) {
                Log::info('ProductTracking: Skipping sync - no Shiprocket order ID', [
                    'order_id' => $order->order_id
                ]);
                return null;
            }

            $tracking = self::updateOrCreate(
                ['order_id' => $order->order_id],
                [
                    'user_id' => $order->user_id,
                    'delivery_status' => (string) $order->delivery_status,
                    'status' => self::mapDeliveryStatusToText($order->delivery_status),
                    'shiprocket_order_id' => (string) $order->shiprocket_order_id,
                    'shiprocket_shipment_id' => (string) $order->shiprocket_shipping_id,
                    'awb_code' => $order->awb_code,
                    'tracking_url' => $trackingUrl,
                    'return_requested' => 0,
                ]
            );

            Log::info('ProductTracking: Synced from order', [
                'order_id' => $order->order_id,
                'shiprocket_order_id' => $order->shiprocket_order_id,
                'awb_code' => $order->awb_code
            ]);

            return $tracking;

        } catch (\Exception $e) {
            Log::error('ProductTracking: Sync failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Update tracking record from webhook data
     * 
     * @param string $orderId The order ID
     * @param int $deliveryStatus The new delivery status
     * @param string|null $deliveredDate Optional delivered date
     * @return bool Success status
     */
    public static function updateFromWebhook(string $orderId, int $deliveryStatus, ?string $deliveredDate = null): bool
    {
        try {
            $tracking = self::where('order_id', $orderId)->first();
            
            if (!$tracking) {
                Log::warning('ProductTracking: Record not found for webhook update', [
                    'order_id' => $orderId
                ]);
                return false;
            }

            $tracking->update([
                'delivery_status' => (string) $deliveryStatus,
                'status' => self::mapDeliveryStatusToText($deliveryStatus),
                'delivered_date' => $deliveredDate,
            ]);

            Log::info('ProductTracking: Updated from webhook', [
                'order_id' => $orderId,
                'delivery_status' => $deliveryStatus
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('ProductTracking: Webhook update failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Map numeric delivery status to text
     */
    protected static function mapDeliveryStatusToText(int $status): string
    {
        $statusMap = [
            0 => 'Pending',
            1 => 'Processing',
            2 => 'Shipped',
            3 => 'Cancelled',
            4 => 'RTO',
            5 => 'Shipping Lock Failed',
            6 => 'Pending AWB',
        ];

        return $statusMap[$status] ?? 'Unknown';
    }

    /**
     * Relationship: Get the order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
