<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
    
}    
