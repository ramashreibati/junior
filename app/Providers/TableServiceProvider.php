<?php

namespace App\Providers;


use App\Models\Tables;
use App\Observers\TableObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Reservation;
use App\Observers\ReservationObserver;

class TableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register observer so it auto-updates table counts
        Tables::observe(TableObserver::class);

        // Register Reservation Observer
        Reservation::observe(ReservationObserver::class);
    }
}
