<?php

namespace App\Models;

use App\Models\MenuItems;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'menu_item_id',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItems::class);
    }
}
