<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\EventBooking;
use App\Observers\EventBookingObserver;

class EventBookingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
            EventBooking::observe(EventBookingObserver::class);
        
    }
}
