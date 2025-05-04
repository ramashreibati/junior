<?php

namespace App\Models;

use App\Models\Restaurants;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $fillable = [
        'city',
        'district',
        'street',
        'details',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurants::class);
    }
}
