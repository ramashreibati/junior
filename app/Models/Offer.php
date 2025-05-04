<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers'; // Ensures Laravel uses the correct table

    protected $fillable = [
        'restaurants_id', 'title', 'description', 
        'discount_percentage', 'valid_from', 'valid_until', 'is_featured'
    ];

    /**
     * Relationship: Each offer belongs to a restaurant.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurants::class);
    }
}
