<?php

namespace App\Http\Controllers;
use App\Models\EventBooking;
use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurants;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;





class CustomerController extends Controller
{
    public function reserveTable(Request $request, $restaurantId)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'number_of_persons' => 'required|integer|min:1',
        'reserve_from' => 'required|date|after:now',
        'reserve_until' => 'required|date|after:reserve_from',
        'notes' => 'nullable|string|max:255',
        'table_type' => 'required|string|max:255'
    ]);

 
    $activeReservation = Reservation::where('user_id', auth()->id())
        ->where('reserve_until', '>', now())
        ->exists();

    if ($activeReservation) {
        return response()->json([
            'status' => 400,
            'message' => "You already have an active reservation. You can book another table after your current reservation expires."
        ], 400);
    }


    $normalizedType = strtolower($request->table_type);

    $availableTables = Tables::whereRaw('LOWER(type) = ?', [$normalizedType])
        ->where('count', '>', 0)
        ->where('is_available', true) 
        ->orderBy('number_of_persons', 'asc')
        ->get();

    if ($availableTables->isEmpty()) {
        return response()->json([
            'status' => 400,
            'message' => "No available '{$request->table_type}' tables. Please select another type."
        ], 400);
    }

    
    $table = $availableTables->where('number_of_persons', '>=', $request->number_of_persons)->first();

    if (!$table) {
        return response()->json([
            'status' => 400,
            'message' => "No available '{$request->table_type}' table can accommodate {$request->number_of_persons} persons."
        ], 400);
    }

  

    Tables::whereRaw('LOWER(type) = ?', [$normalizedType])
        ->decrement('count', 1);


    $table->update([
        'count' => $table->count - 1,
        'is_available' => false 
    ]);



    //Create the reservation
    $reservation = Reservation::create([
        'user_id' => auth()->id(),
        'table_id' => $table->id,
        'restaurant_id' => $restaurantId,
        'name' => $request->name,
        'number_of_persons' => $request->number_of_persons,
        'reserve_from' => $request->reserve_from,
        'reserve_until' => $request->reserve_until,
        'notes' => $request->notes,
        'status' => 'upcoming',
    ]);

    return response()->json([
        'status' => 200,
        "message" => "Table '{$table->type}' (capacity: {$table->number_of_persons}) reserved successfully!",
        "reservation_details" => $reservation
    ], 200);
}





public function bookEvent(Request $request, $restaurantId)
{
    $request->validate([
        'event_name' => 'required|string|max:255',
        'number_of_persons' => 'required|integer|min:1',
        'book_from' => 'required|date|after:now',
        'book_until' => 'required|date|after:book_from',
        'event_details' => 'nullable|string|max:1000',
        'table_type' => 'required|string|max:255'
    ]);

     
     $activeReservation = Reservation::where('user_id', auth()->id())
     ->where('reserve_until', '>', now())
     ->exists();

    if ($activeReservation) {
        return response()->json([
            'status' => 400,
            'message' => "You already have an active event. You can book another time after your current event expires."
        ], 400);
    }

    
    $availableTables = Tables::whereRaw('LOWER(type) = ?', [strtolower($request->table_type)])
        ->where('count', '>', 0)
        ->where('is_available', true) // ✅ Only select available tables
        ->orderBy('number_of_persons', 'asc')
        ->get();

    if ($availableTables->isEmpty()) {
        return response()->json([
            'status' => 400,
            'message' => "No available '{$request->table_type}' tables. Please select another type."
        ], 400);
    }

    $selectedTables = [];
    $totalCapacity = 0;
    $remainingPersons = $request->number_of_persons;

   

    foreach ($availableTables as $table) {
        if ($remainingPersons > 0) {
            $selectedTables[] = $table->id;
            $totalCapacity += $table->number_of_persons;
            $remainingPersons -= $table->number_of_persons;
        }
    }



    if ($totalCapacity < $request->number_of_persons) {
        return response()->json([
            'status' => 400,
            'message' => "No available '{$request->table_type}' tables can accommodate {$request->number_of_persons} persons.",
            'suggested_table_options' => $availableTables->pluck('number_of_persons')
        ], 400);
    }


    $typeCounts = [];

    foreach ($selectedTables as $tableId) {
        $table = Tables::find($tableId);
        if ($table) {
            $table->is_available = false; 
            $table->save();


            if (!isset($typeCounts[$table->type])) {
                $typeCounts[$table->type] = 0;
            }
            $typeCounts[$table->type] += 1; 
        }
    }

    foreach ($typeCounts as $type => $countBooked) {
        Tables::whereRaw('LOWER(type) = ?', [strtolower($type)])
            ->decrement('count', $countBooked);
    }




    $booking = EventBooking::create([
        'user_id' => auth()->id(),
        'restaurant_id' => $restaurantId,
        'event_name' => $request->event_name,
        'number_of_persons' => $request->number_of_persons,
        'book_from' => $request->book_from,
        'book_until' => $request->book_until,
        'event_details' => $request->event_details,
        'status' => 'upcoming'
    ]);



    foreach ($selectedTables as $tableId) {
        DB::table('event_booking_tables')->insert([
            'event_booking_id' => $booking->id,
            'table_id' => $tableId
        ]);
    }

    return response()->json([
        'status' => 200,
        "message" => "Event '{$request->event_name}' reserved successfully!",
        "booking_details" => $booking
    ], 200);
}




}