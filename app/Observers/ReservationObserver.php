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
            $reservation->delete();

            // 🔹 After deleting, trigger table count update
            $tableType = Tables::where('id', $reservation->table_id)->value('type');

            if ($tableType) {
                Tables::whereRaw('LOWER(type) = ?', [strtolower($tableType)])
                      ->update(['count' => Tables::whereRaw('LOWER(type) = ?', [strtolower($tableType)])->count()]);
            }
        }
    }
}
