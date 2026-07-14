<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_type_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'address_type_id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'address_type_id');
    }
}
