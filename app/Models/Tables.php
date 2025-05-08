<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\Restaurants;
use App\Models\EventBooking;
use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
   

    public $timestamps = false;

    protected $fillable = [
        'type',
        'restaurant_id',
        'number_of_persons',
        'count',
        'is_available'
    ];

    public function eventBookings()
    {
        return $this->belongsToMany(EventBooking::class, 'event_booking_tables', 'table_id', 'event_booking_id'); // ✅ Pivot table reference
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'table_id');
    }

   
}
