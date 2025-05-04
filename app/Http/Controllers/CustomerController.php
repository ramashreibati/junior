<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurants;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        return response()->json([
            'message' => 'Welcome to the customer dashboard!',
            'data' => $user
        ]);
    }

 

   
    
    
}
