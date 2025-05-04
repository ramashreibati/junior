<?php

namespace App\Models;

use App\Models\EventBooking;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $fillable = [
        'type',
        'Description',
        'restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }

}