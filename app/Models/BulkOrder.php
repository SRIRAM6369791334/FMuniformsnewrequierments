<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulkOrder extends Model
{
    protected $primaryKey = 'bulk_order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'bulk_order_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'institution',
        'uniform_type',
        'quantity',
        'budget',
        'message',
        'status',
    ];

    /**
     * Generate the next bulk order ID
     * Format: ORD-FM-BULK-XXX
     */
    public static function generateNextBulkOrderId(): string
    {
        $latestOrder = self::where('bulk_order_id', 'like', 'ORD-FM-BULK-%')
            ->orderByRaw('CAST(SUBSTRING(bulk_order_id, 13) AS UNSIGNED) DESC')
            ->first();

        $nextNumber = 1;

        if ($latestOrder) {
            $currentNumber = (int) substr($latestOrder->bulk_order_id, 12);
            $nextNumber = $currentNumber + 1;
        }

        return 'ORD-FM-BULK-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    protected $casts = [
        'quantity' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the user that owns the bulk order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
