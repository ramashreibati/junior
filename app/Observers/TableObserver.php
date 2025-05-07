<?php

namespace App\Observers;

use App\Models\Tables;

class TableObserver
{
    public function created(Tables $table)
    {
        Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])
            ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])->count()]);
    }

    public function deleted(Tables $table)
    {
        Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])
            ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($table->type)])->count()]);
    }
}
