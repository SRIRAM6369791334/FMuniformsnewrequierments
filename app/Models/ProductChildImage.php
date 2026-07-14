<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChildImage extends Model
{
    use HasFactory;

    protected $table = 'product_child_images';

    protected $fillable = [
        'product_id',
        'variant_id',
        'product_child_image',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'variant_id' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
