<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'discount_code',
        'discount_amount',
        'expiry_date',
        'restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
