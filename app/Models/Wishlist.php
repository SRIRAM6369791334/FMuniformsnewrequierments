<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'product_varient_id',
        'product_quantity',
        'product_color',
        'product_image',
        'price',
        'product_size',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'product_varient_id' => 'integer',
        'product_quantity' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
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
    public static function getUserWishlist($userId = null)
    {
        $query = self::with(['product.category', 'productVariant']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->latest()->get();
    }

    public static function isInWishlist($productId, $productVariantId = null, $userId = null)
    {
        $query = self::where('product_id', $productId);

        if ($productVariantId) {
            $query->where('product_varient_id', $productVariantId);
        } else {
            $query->whereNull('product_varient_id');
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->exists();
    }


}
