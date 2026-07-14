<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'product_orders';

    protected $fillable = [
        'order_id',
        'order_name',
        'total_amount',
        'gst_amount',
        'discount_amount',
        'delivery_charge',
        'grand_total_amount',
        'coupons_id',
        'date_ordered_on',
        'delivery_person_id',
        'is_delivery_assigned',
        'user_id',
        'guest_user_id',
        'payment_status',
        'delivery_status',
        'current_status',
        'is_cancelled',
        'approve_staus',
        'cancel_reason',
        'shiprocket_order_id',
        'shiprocket_shipping_id',
        'awb_code',
        'razorpay_order_id',
        'razorpay_payment_id',
        'payment_method',
        'coupon_code',
        'tracking_id',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'gst_amount' => 'integer',
        'discount_amount' => 'integer',
        'delivery_charge' => 'integer',
        'grand_total_amount' => 'integer',
        'is_delivery_assigned' => 'integer',
        'payment_status' => 'integer',
        'delivery_status' => 'integer',
        'current_status' => 'integer',
        'is_cancelled' => 'integer',
        'approve_staus' => 'integer',
        'shiprocket_order_id' => 'integer',
        'shiprocket_shipping_id' => 'integer',
        'date_ordered_on' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the guest user that owns the order.
     */
    public function guestUser(): BelongsTo
    {
        return $this->belongsTo(GuestUser::class, 'guest_user_id');
    }

    /**
     * Get the order slots for the order.
     */
    public function orderSlots(): HasMany
    {
        return $this->hasMany(ProductSlot::class, 'order_id', 'order_id');
    }

    /**
     * Get the order addresses for the order.
     */
    public function orderAddresses(): HasMany
    {
        return $this->hasMany(ProductOrderUserAddress::class, 'order_id', 'order_id');
    }


    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return $this->current_status == 0 && $this->is_cancelled == 0;
    }

    /**
     * Generate the next sequential order ID
     * Format: ORD-FM-XXX (001, 002, ..., 9999)
     */
    public static function generateNextOrderId(): string
    {
        // Find the highest existing order ID with ORD-FM- pattern
        $latestOrder = self::where('order_id', 'like', 'ORD-FM-%')
            ->orderByRaw('CAST(SUBSTRING(order_id, 8) AS UNSIGNED) DESC')
            ->first();

        $nextNumber = 1; // Default starting number

        if ($latestOrder) {
            // Extract the numeric part from the order ID (after "ORD-FM-")
            $currentNumber = (int) substr($latestOrder->order_id, 7);
            $nextNumber = $currentNumber + 1;
        }

        // Format with leading zeros (3 digits for 001-999, then 4 digits for 1000+)
        if ($nextNumber < 1000) {
            $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return 'ORD-FM-' . $formattedNumber;
    }

    /**
     * Check if order has Shiprocket shipment
     */
    public function hasShiprocketShipment(): bool
    {
        return !empty($this->shiprocket_order_id);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    /**
     * Get tracking URL for the order
     */
    public function getTrackingUrl(): ?string
    {
        if ($this->awb_code) {
            return route('tracking', ['orderId' => $this->order_id]);
        }
        return null;
    }
}
