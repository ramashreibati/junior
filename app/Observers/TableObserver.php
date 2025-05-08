<?php

namespace App\Observers;

use App\Models\Tables;
use App\Models\Reservation;

class TableObserver
{
    public function created(Tables $table): void
    {
    
        Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])
              ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])->sum('count')]);

        $table->is_available = true;
        $table->save();
    }

    public function updated(Tables $table): void
    {

        if ($table->count <= 0) {
            Tables::where('id', $table->id)->update(['is_available' => false]); // 
        }
    }

    public function restored(Tables $table): void
    {
      
        $activeReservations = Reservation::where('table_id', $table->id)
            ->where('reserve_until', '>', now())
            ->exists();

        if (!$activeReservations && $table->count > 0) {
            Tables::where('id', $table->id)->update(['is_available' => true]); 
        }
    }
}
