<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    

    public $timestamps = false; // Prevents Laravel from using 'updated_at' and 'created_at'


    protected $fillable = [
        'type', 
        'restaurant_id',
        'number_of_persons'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class,'table_id');
    }

    
}
