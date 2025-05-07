<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class CleanupReservations extends Command
{
    protected $signature = 'cleanup:reservations';
    protected $description = 'Deletes expired reservations from the database';

    public function handle()
    {
        $expiredReservations = Reservation::where('reserve_until', '<', now())->get();

        if ($expiredReservations->isEmpty()) {
            Log::info('No expired reservations to delete.');
            return;
        }

        foreach ($expiredReservations as $reservation) {
            Log::info("Deleting expired reservation ID: {$reservation->id}");
            $reservation->delete();
        }

        Log::info('Expired reservations cleanup completed.');
    }
}

