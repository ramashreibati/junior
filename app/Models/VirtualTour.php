<?php

namespace App\Models;

use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class VirtualTour extends Model
{
    protected $table = 'virtual_tour'; // ✅ Ensures Laravel uses the correct table

    protected $fillable = [
        'video_link',
        'restaurants_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class,'restaurants_id');
    }
}