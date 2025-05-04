<?php

namespace App\Models;

use App\Models\Discount;
use App\Models\Event;
use App\Models\Feature;
use App\Models\Images;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Tables;
use App\Models\User;
use App\Models\UserRate;
use App\Models\VirtualTour;
use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $table = 'restaurants';
    protected $fillable = [
        'name',
        'location',
        'type',
        'cuisine_type',
        // 'google_map_link',
        'event_calender',
        'ratings',
        'user_id',
        // 'address_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function address()
    // {
    //     return $this->belongsTo(address::class);
    // }

    public function tables()
    {
        return $this->hasMany(Tables::class);
    }
    public function images()
    {
        return $this->hasMany(Images::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function virtualTour()
    {
        return $this->hasOne(VirtualTour::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // public function waitlists()
    // {
    //     return $this->hasMany(Waitlist::class);
    // }

    public function ratings()
    {
        return $this->hasMany(UserRate::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
