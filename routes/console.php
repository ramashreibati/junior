<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Reservation;
use App\Models\Tables;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


return function (Schedule $schedule) {
    // Schedule reservation cleanup every hour
    $schedule->command('cleanup:reservations')->hourly();
  
};
