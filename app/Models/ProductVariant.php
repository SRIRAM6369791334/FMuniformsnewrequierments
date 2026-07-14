<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_varient';

    protected $fillable = [
        'categoryid',
        'subcategoryid',
        'product_id',
        'varient',
        'varient_img',
        'varient_name',
        'value',
        'offer_price',
        'mrp_price',
        'product_qty',
        'low_stock',
        'hot_deals',
        'Popular_products',
        'product_gst',
        'subcatename',
        'size_value',
        'color_value',
        'slug',
        'weight',
    ];

    protected $casts = [
        'categoryid' => 'integer',
        'product_id' => 'integer',
        'varient' => 'integer',
        'offer_price' => 'integer',
        'mrp_price' => 'integer',
        'product_qty' => 'integer',
        'hot_deals' => 'integer',
        'Popular_products' => 'integer',
        'product_gst' => 'integer',
        'weight' => 'decimal:2',
    ];

    // Accessors for backwards compatibility
    public function getVariantIdAttribute()
    {
        return $this->id;
    }

    public function getVariantPriceAttribute()
    {
        return $this->offer_price ?: $this->mrp_price;
    }

    public function getVariantQuantityAttribute()
    {
        return $this->product_qty;
    }

    public function getVariantImageAttribute()
    {
        return $this->varient_img;
    }

    public function getVariantSpecificationAttribute()
    {
        return $this->value;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryid');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategoryid');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_varient_id', 'id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_varient_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'prod_var_id', 'id');
    }
}
