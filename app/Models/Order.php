<?php

namespace App\Models;

use App\Models\Discount;
use App\Models\OrderDetails;
use App\Models\Restaurants;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = [
        'price',
        'status',
        'user_id',
        'restaurant_id',
        'discount_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
