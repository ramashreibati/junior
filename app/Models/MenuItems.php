<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $fillable = [
        'name',
        'type',
        'price',
        'description',
        'menu_id'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
