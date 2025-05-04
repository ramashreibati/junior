<?php

namespace App\Models;

use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = [
        'image','restaurant_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }
}
