<?php

namespace App\Models;

use App\Models\Restaurants;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserRate extends Model
{
    use HasFactory;

    protected $table = 'user_rate';

    protected $fillable = [
        'rate',
        'review',
        'user_id',
        'restaurants_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurants()
    {
        return $this->belongsTo(Restaurants::class,'restaurants_id');
    }
}
