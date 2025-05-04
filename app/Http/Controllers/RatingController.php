<?php

namespace App\Http\Controllers;

use App\Models\UserRate;
use App\Models\Restaurants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rate(Request $request, Restaurants $restaurant)
    {
        $request->validate([
            'rate' => 'required|integer|min:1|max:5'
        ]);
    
        $user = Auth::user(); // Get authenticated user
    
        // Check if the user has already rated this restaurant
        $existingRating = UserRate::where('user_id', $user->id)
                                  ->where('restaurants_id', $restaurant->id) // Match column name
                                  ->first();
    
        if ($existingRating) {
            // Update existing rating
            $existingRating->rate = $request->rate;
            $existingRating->save();
            return response()->json(['message' => 'Rating updated successfully!'], 200);
        } else {
            // Create a new rating entry
            $rating = new UserRate();
            $rating->user_id = $user->id;
            $rating->restaurants_id = $restaurant->id; // Match column name
            $rating->rate = $request->rate;
            $rating->save();
            return response()->json(['message' => 'Rating submitted successfully!'], 201);
        }
    }
    
    public function unrate(Restaurants $restaurant)
    {
        $user = Auth::user(); // Get authenticated user
    
        $rating = UserRate::where('user_id', $user->id)
                          ->where('restaurants_id', $restaurant->id)
                          ->first();
    
        if ($rating) {
            $rating->delete(); // Remove rating from the database
            return response()->json(['message' => 'Rating removed successfully!'], 200);
        } else {
            return response()->json(['message' => 'Rating not found.'], 404);
        }
    }

    public function getUserRating(Restaurants $restaurant)
    {
        $user = Auth::user();

        $rating = UserRate::where('user_id', $user->id)
                         ->where('restaurants_id', $restaurant->id)
                         ->first();

        return response()->json([
            'rating' => $rating ? $rating->rate : null
        ]);
    }


    public function addReview(Request $request, Restaurants $restaurant)
    {
        $request->validate([
            'review' => 'required|string|max:500'  // Require review input
        ]);

        $user = Auth::user();

        $existingReview = UserRate::where('user_id', $user->id)
                                ->where('restaurants_id', $restaurant->id)
                                ->first();

        if ($existingReview) {
            $existingReview->review = $request->review; // Update review
            $existingReview->save();
            return response()->json(['message' => 'Review updated successfully!'], 200);
        } else {
            return response()->json(['message' => 'No rating found for this restaurant.'], 404);
        }
    }

    public function getReview(Restaurants $restaurant)
    {
        $user = Auth::user();

        $review = UserRate::where('user_id', $user->id)
                        ->where('restaurants_id', $restaurant->id)
                        ->first();

        return response()->json([
            'review' => $review ? $review->review : null
        ]);
    }



    public function removeReview(Restaurants $restaurant)
    {
        $user = Auth::user();

        $review = UserRate::where('user_id', $user->id)
                        ->where('restaurants_id', $restaurant->id)
                        ->first();

        if ($review) {
            $review->review = null; // Remove review text but keep rating
            $review->save();
            return response()->json(['message' => 'Review removed successfully!'], 200);
        } else {
            return response()->json(['message' => 'Review not found.'], 404);
        }
    }


}







