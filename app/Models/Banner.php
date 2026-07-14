<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners_images';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_url',
        'banner_position',
        'sort_order',
    ];

    protected $casts = [
        'banner_position' => 'string',
        'sort_order' => 'integer',
    ];
}
