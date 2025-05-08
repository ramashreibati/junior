<?php

namespace App\Observers;
use Carbon\Carbon;
use App\Models\EventBooking;
use App\Models\Tables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EventBookingObserver
{
    /**
     * Handle the EventBooking "created" event.
     */
    public function created(EventBooking $eventBooking): void
    {
        //
    }

    /**
     * Handle the EventBooking "updated" event.
     */
    public function updated(EventBooking $booking)
    {
        if ($booking->book_until < now()) {
            Log::info("Restoring tables for expired event ID: {$booking->id}");
    
           
            $tableIds = DB::table('event_booking_tables')
                ->where('event_booking_id', $booking->id)
                ->pluck('table_id');
    
            $typeCounts = [];
    
            if (!empty($tableIds)) {
                foreach ($tableIds as $tableId) {
                    $table = Tables::find($tableId);
                    if ($table) {
              
                        $table->is_available = true; 
                        $table->save();
    
                    
                        if (!isset($typeCounts[$table->type])) {
                            $typeCounts[$table->type] = 0;
                        }
                        $typeCounts[$table->type] += 1;
                    }
                }
            }
    
            foreach ($typeCounts as $type => $countRestored) {
                Tables::whereRaw('LOWER(type) = ?', [strtolower($type)])
                    ->increment('count', $countRestored);
            }
    
      
            DB::table('event_booking_tables')->where('event_booking_id', $booking->id)->delete();
 
            $booking->delete();
        }
    }
    



    /**
     * Handle the EventBooking "deleted" event.
     */
    public function deleted(EventBooking $eventBooking): void
    {
        //
    }

    /**
     * Handle the EventBooking "restored" event.
     */
    public function restored(EventBooking $eventBooking): void
    {
        //
    }

    /**
     * Handle the EventBooking "force deleted" event.
     */
    public function forceDeleted(EventBooking $eventBooking): void
    {
        //
    }
}
