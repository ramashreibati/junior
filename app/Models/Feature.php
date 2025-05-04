<?php

namespace App\Models;

use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'type',
        'description',
        'restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }
}
