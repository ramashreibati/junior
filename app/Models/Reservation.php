<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Restaurants;
use App\Models\Tables;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $fillable = [
        'name',
        'number',
        'table_number',
        'notes',
        'user_id',
        'sender_id',
        'restaurant_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function table()
    {
        return $this->belongsTo(Tables::class, 'table_number', 'table_number');
    }
}
