<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'productstocks';

    protected $fillable = [
        'productid',
        'category_id',
        'subcategory_id',
        'pro_ver_id',
        'productname',
        'overallstock',
        'availablestock',
        'salestock',
        'low_stocks',
        'last_stockupdate_date',
    ];

    protected $casts = [
        'productid' => 'integer',
        'category_id' => 'integer',
        'subcategory_id' => 'integer',
        'pro_ver_id' => 'integer',
        'overallstock' => 'integer',
        'availablestock' => 'integer',
        'salestock' => 'integer',
        'low_stocks' => 'integer',
        'last_stockupdate_date' => 'datetime',
    ];

    /**
     * Get the product that owns this stock record.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }

    /**
     * Get the product variant that owns this stock record.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'pro_ver_id');
    }

    /**
     * Get the category for this stock record.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the subcategory for this stock record.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    /**
     * Reduce stock when a purchase is made.
     *
     * @param int $quantity The quantity to reduce
     * @return bool
     */
    public function reduceStock(int $quantity): bool
    {
        if ($this->availablestock < $quantity) {
            return false;
        }

        $this->availablestock -= $quantity;
        $this->salestock += $quantity;
        $this->last_stockupdate_date = now();
        
        return $this->save();
    }

    /**
     * Check if stock is low.
     *
     * @return bool
     */
    public function isLowStock(): bool
    {
        return $this->availablestock <= $this->low_stocks;
    }

    /**
     * Find stock record by product and variant.
     *
     * @param int $productId
     * @param int|null $variantId
     * @return ProductStock|null
     */
    public static function findByProductVariant(int $productId, ?int $variantId = null): ?ProductStock
    {
        $query = self::where('productid', $productId);
        
        if ($variantId) {
            $query->where('pro_ver_id', $variantId);
        }
        
        return $query->first();
    }
}
