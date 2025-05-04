<?php

namespace App\Models;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    protected $table = 'event_booking';
    protected $fillable = [
        'event_details',
        'booking_date',
        'user_id',
        'event_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
