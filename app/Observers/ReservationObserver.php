<?php
namespace App\Observers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class ReservationObserver
{
    public function created(Reservation $reservation)
    {
        // Log reservation creation for debugging
        Log::info("New reservation created with ID: {$reservation->id}");
    }

    public function updated(Reservation $reservation)
    {
        if ($reservation->reserve_until < now()) {
            Log::info("Deleting expired reservation ID: {$reservation->id}");
            $reservation->delete();
        }
    }
}
