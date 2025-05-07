<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRate;
class ManagerController extends Controller
{
    public function index()
    {
       $user = Auth::user();
    
        return response()->json([
            'message' => 'Welcome to the manager dashboard!',
            'data' => $user
        ]);
    }



        public function getRatingsAndReviews()
        {
            // The RoleMiddleware already verified that the user is a manager!
            $ratingsReviews = UserRate::with(['user', 'restaurants'])->get();
    
            return response()->json([
                'status' => 'Success',
                'ratings_reviews' => $ratingsReviews,
            ]);
        }
    
    
    
    


    
    
}    
