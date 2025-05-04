<?php

namespace App\Models;

use App\Models\MenuItems;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'name',
        'description',
        'restaurants_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItems::class,'menu_id');
    }
}
