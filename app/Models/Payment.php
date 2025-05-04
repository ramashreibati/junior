<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = [
        'payment_method',
        'amountPayed',
        'user_id',
        'reservation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
