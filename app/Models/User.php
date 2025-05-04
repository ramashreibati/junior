<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Restaurants;
use App\Models\UserRate;
use App\Models\address;
use App\Models\Order;
use App\Models\EventBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'reward_points',
        'role',
        'saved_favorites'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'saved_favorites' => 'array'
    ];

    public function restaurants()
    {
        return $this->hasMany(Restaurants::class);
    }

    public function address()
    {
        return $this->hasMany(address::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // public function waitlists()
    // {
    //     return $this->hasMany(Waitlist::class);
    // }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function ratings()
    {
        return $this->hasMany(UserRate::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function eventBookings()
    {
        return $this->hasMany(EventBooking::class);
    }

    // public function notifications()
    // {
    //     return $this->morphMany(Notification::class, 'notifiable');
    // }
}
