<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'guest_user_id',
        'ip_address',
        'product_id',
        'product_varient_id',
        'product_quantity',
        'product_name',
        'product_color',
        'price',
        'product_size',
        'product_image',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'product_varient_id' => 'integer',
        'product_quantity' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_varient_id', 'id');
    }

    // Helper methods
    public static function getUserCart($userId = null, $guestUserId = null)
    {
        $query = self::with(['product.category', 'productVariant']);

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestUserId) {
            $query->where('guest_user_id', $guestUserId)->whereNull('user_id');
        }

        return $query->latest()->get();
    }

    public static function getCartItemCount($userId = null, $guestUserId = null)
    {
        $query = self::selectRaw('SUM(product_quantity) as total_items');

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestUserId) {
            $query->where('guest_user_id', $guestUserId)->whereNull('user_id');
        }

        $result = $query->first();
        return $result ? $result->total_items : 0;
    }

    public static function getCartTotal($userId = null, $guestUserId = null)
    {
        $cartTable = (new self)->getTable();

        $query = self::selectRaw("SUM(CAST({$cartTable}.price AS DECIMAL(10,2)) * {$cartTable}.product_quantity) as total");

        if ($userId) {
            $query->where("{$cartTable}.user_id", $userId);
        } elseif ($guestUserId) {
            $query->where("{$cartTable}.guest_user_id", $guestUserId)->whereNull("{$cartTable}.user_id");
        }

        $result = $query->first();
        return $result && $result->total ? (float) $result->total : 0;
    }

    public static function isInCart($productId, $productVariantId = null, $userId = null, $guestUserId = null)
    {
        $query = self::where('product_id', $productId);

        if ($productVariantId) {
            $query->where('product_varient_id', $productVariantId);
        } else {
            $query->whereNull('product_varient_id');
        }

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestUserId) {
            $query->where('guest_user_id', $guestUserId)->whereNull('user_id');
        }

        return $query->exists();
    }

    /**
     * Transfer guest cart items to user account
     */
    public static function transferGuestCart($guestUserId, $userId)
    {
        // Find all guest cart items for this guest_user_id
        $guestCartItems = self::where('guest_user_id', $guestUserId)
            ->whereNull('user_id')
            ->get();

        $transferredCount = 0;

        foreach ($guestCartItems as $cartItem) {
            // Check if user already has this item in their cart
            $existingItem = self::where('user_id', $userId)
                ->where('product_id', $cartItem->product_id)
                ->where('product_varient_id', $cartItem->product_varient_id)
                ->first();

            if ($existingItem) {
                // Update quantity if item already exists
                $existingItem->update([
                    'product_quantity' => $existingItem->product_quantity + $cartItem->product_quantity
                ]);
                // Delete the guest cart item
                $cartItem->delete();
            } else {
                // Transfer the item to user account
                $cartItem->update([
                    'user_id' => $userId,
                    'guest_user_id' => null // Clear guest ID since it's now associated with user
                ]);
            }

            $transferredCount++;
        }

        return $transferredCount;
    }
}
