<?php

namespace App\Http\Controllers;

use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurants;
use App\Models\User;
use App\Models\Reservation;


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


                //Check if the user has an active reservation
            $activeReservation = Reservation::where('user_id', auth()->id())
            ->where('reserve_until', '>', now()) // Ensures reservation is still active
            ->exists();

        if ($activeReservation) {
            return response()->json([
                'status' => 400,
                'message' => "You already have an active reservation. You can book another table after your current reservation expires."
            ], 400);
        }
    
        // Normalize table type for case-insensitive search
        $normalizedType = strtolower($request->table_type);
    
        // Find all tables of this type
        $availableTables = Tables::whereRaw('LOWER(type) = ?', [$normalizedType])
            ->where('count', '>', 0)
            ->get();
    
        if ($availableTables->isEmpty()) {
            return response()->json([
                'status' => 400,
                'message' => "No available '{$request->table_type}' tables at the moment. Please select another type."
            ], 400);
        }
    
        // Select one table to associate with the reservation
        $table = $availableTables->first();
    
        // Ensure table can accommodate requested persons
        if ($request->number_of_persons > $table->number_of_persons) {
            return response()->json([
                'status' => 400,
                'message' => "This table can only accommodate {$table->number_of_persons} persons."
            ], 400);
        }


//Reduce count for ALL tables of the same type
Tables::whereRaw('LOWER(type) = ?', [$normalizedType])->decrement('count');

       

    
    $reservation = Reservation::create([
        'user_id' => auth()->id(),
        'table_id' => $table->id,
        'restaurant_id' => $restaurantId,
        'name' => $request->name,
        'number_of_persons' => $request->number_of_persons,
        'reserve_from' => $request->reserve_from,
        'reserve_until' => $request->reserve_until,
        'notes' => $request->notes,
        'status'=> 'upcoming',
       
    ]);

    
        return response()->json([
            'status' => 200,
            "message" => "Table '{$table->type}' reserved successfully!",
            "reservation_details" => $reservation,
            "remaining_tables_of_this_type" => Tables::whereRaw('LOWER(type) = ?', [$normalizedType])->sum('count')
        ], 200);
    }
    


}