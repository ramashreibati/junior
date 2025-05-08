<?php

namespace App\Models;
use App\Models\Tables;
use App\Models\Restaurants;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    protected $table = 'event_bookings';

    protected $fillable = [
        'event_name',
        'user_id',
        'restaurant_id', 
        'event_details',
        'number_of_persons',
        'book_from',
        'book_until',
        'status' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class, 'restaurant_id'); 
    }

    public function tables()
    {
        return $this->belongsToMany(Tables::class, 'event_booking_tables', 'event_booking_id', 'table_id'); 
    }
}
