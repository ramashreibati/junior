<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\EventBooking;
use App\Models\Tables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupReservations extends Command
{
    protected $signature = 'cleanup:reservations';
    protected $description = 'Deletes expired reservations and event bookings, updating table count and availability';

    public function handle()
    {
        
        $expiredReservations = Reservation::where('reserve_until', '<', now())->get();

        if ($expiredReservations->isEmpty()) {
            Log::info('No expired reservations to delete.');
        } else {
            foreach ($expiredReservations as $reservation) {
                Log::info("Deleting expired reservation ID: {$reservation->id}");

                $table = Tables::find($reservation->table_id);
                if ($table) {
                    $table->count += 1;
                    $table->is_available = true;
                    $table->save();
                }

                $reservation->delete();
            }
            Log::info('Expired reservations cleanup completed.');
        }

       
        $expiredEvents = EventBooking::where('book_until', '<', now())->get();

        if ($expiredEvents->isEmpty()) {
            Log::info('No expired event bookings to delete.');
        } else {
            foreach ($expiredEvents as $event) {
                Log::info("Deleting expired event booking ID: {$event->id}");

             
                $tableIds = DB::table('event_booking_tables')
                    ->where('event_booking_id', $event->id)
                    ->pluck('table_id');

                if (!empty($tableIds)) {
                 
                    foreach ($tableIds as $tableId) {
                        $table = Tables::find($tableId);
                        if ($table) {
                            $table->count += 1;
                            $table->is_available = true;
                            $table->save();
                        }
                    }

                    //Delete pivot table entries
                    DB::table('event_booking_tables')->where('event_booking_id', $event->id)->delete();
                }

                $event->delete();
            }
            Log::info('Expired event bookings cleanup completed.');
        }
    }
}
