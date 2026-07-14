<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'product_name',
        'slug',
        'prod_unique_name',
        'product_quantity',
        'product_mrp_price',
        'product_regular_price',
        'product_description',
        'product_image',
        'product_specification',
        'product_specfication',
        'brand_name',
        'brand_material',
        'brand_type',
        'approval_days',
        'unit_value',
        'product_value',
        'cate_name',
        'subcate_name',
        'size_value',
        'size_chart_image',
        'weight',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'product_quantity' => 'integer',
        'product_mrp_price' => 'integer',
        'product_regular_price' => 'integer',
        'approval_days' => 'integer',
        'size_value' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('status', 'approved');
    }

    public function productSlots()
    {
        return $this->hasMany(ProductSlot::class, 'product_id');
    }

    public function productOrders()
    {
        return $this->hasManyThrough(ProductOrder::class, ProductSlot::class, 'product_id', 'order_id', 'id', 'order_id');
    }

    public function productChildImages()
    {
        return $this->hasMany(ProductChildImage::class, 'product_id');
    }
}
