<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User is not authenticated!'
            ], 401);
        }

        $user = Auth::user();
        if ($user->role != $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not have the required role!',
                'user_role' => $user->role,
                'expected_role' => $role
            ], 403);
        }

        return $next($request);
    }
}

