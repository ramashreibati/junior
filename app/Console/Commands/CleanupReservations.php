<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Tables;
use Illuminate\Support\Facades\Log;

class CleanupReservations extends Command
{
    protected $signature = 'cleanup:reservations';
    protected $description = 'Deletes expired reservations and updates table count';

    public function handle()
    {
        $expiredReservations = Reservation::where('reserve_until', '<', now())->get();

        if ($expiredReservations->isEmpty()) {
            Log::info('No expired reservations to delete.');
            return;
        }

        foreach ($expiredReservations as $reservation) {
            Log::info("Deleting expired reservation ID: {$reservation->id}");

            // Get table type for updating count
            $tableType = Tables::where('id', $reservation->table_id)->value('type');

            if ($tableType) {
                Tables::whereRaw('LOWER(type) = ?', [strtolower($tableType)])
                      ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($tableType)])->count()]);
            }

            $reservation->delete();
        }

        Log::info('Expired reservations cleanup completed.');
    }
}

