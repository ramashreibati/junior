<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    protected $fillable = [
        'type',
        'count',
        'description',
        'restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
