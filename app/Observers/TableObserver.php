<?php

namespace App\Observers;

use App\Models\Tables;
use App\Models\Reservation;

class TableObserver
{
    public function created(Tables $table): void
    {
        // Update count for the table type when a new table is added
        Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])
              ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])->count()]);
    }

    public function deleted(Tables $table): void
    {
        // Update count when a table is deleted
        Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])
              ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])->count()]);
    }

   
}
