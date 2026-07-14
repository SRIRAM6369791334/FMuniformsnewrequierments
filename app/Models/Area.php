<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_name',
        'area_pincode',
    ];

    protected $casts = [
        'area_pincode' => 'integer',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'area_id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'area_id');
    }
}
