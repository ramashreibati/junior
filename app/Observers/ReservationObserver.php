<?php
namespace App\Observers;

use App\Models\Reservation;
use App\Models\Tables;
use Illuminate\Support\Facades\Log;

class ReservationObserver
{
    public function created(Reservation $reservation)
    {
      
        Log::info("New reservation created with ID: {$reservation->id}");
    }

    public function updated(Reservation $reservation)
    {
        if ($reservation->reserve_until < now()) {
            Log::info("Deleting expired reservation ID: {$reservation->id}");

        
            $table = Tables::find($reservation->table_id);
            if ($table) {
                $table->count += 1;

                $activeReservations = Reservation::where('table_id', $table->id)
                    ->where('reserve_until', '>', now())
                    ->exists();

                if (!$activeReservations) {
                    $table->is_available = true; 
                }

                $table->save();
            }

            $reservation->delete();
        }
    }

}
