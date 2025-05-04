<?php

namespace App\Http\Controllers;

use App\Models\VirtualTour;
use App\Models\Restaurants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RestaurantController extends Controller
{
    public function search(Request $request)
    {
        $query = Restaurants::query();
    
        // Validate ratings filter
        if ($request->filled('ratings')) {
            $query->where('ratings', '=', (float) $request->input('ratings'));
        }
        
        
    
        // Normalize 'type' filter for case-insensitive search
        if ($request->filled('type')) {
            $query->whereRaw('LOWER(type) = ?', [strtolower($request->input('type'))]);
        }
        
    
        // Normalize 'cuisine_type' filter for case-insensitive search
        if ($request->filled('cuisine_type')) {
            $cuisineTypes = explode(',', $request->input('cuisine_type')); // Split the values into an array
            $query->whereIn('cuisine_type', $cuisineTypes); // Use whereIn() to match multiple cuisines
        }
        
    
        // Debugging: Check the actual SQL query
        \Log::info($query->toSql());

        
    
        return response()->json($query->get());
    }
    



    public function getRestaurantTour(Restaurants $restaurant)
{
    $tour = VirtualTour::where('restaurants_id', $restaurant->id)->first();

    if (!$tour || empty($tour->video_link)) {
        return response()->json(['message' => 'No virtual tour available for this restaurant'], 404);
    }

    return response()->json([
        'restaurant_name' => $restaurant->name,
        'video_link' => $tour->video_link
    ]);
}


    




}