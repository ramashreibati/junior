<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ManagerController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\RatingController;
use App\Models\Restaurants;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomNotification;





//login and register

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
});





//logout and get user infos

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});






//search

Route::get('/restaurants/search', [RestaurantController::class, 'search']);






//diffirent dashboards 

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->middleware(RoleMiddleware::class.':1');
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->middleware(RoleMiddleware::class.':2');
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->middleware(RoleMiddleware::class.':3');
});







//rate

Route::post('/rate-restaurant/{restaurant}', [RatingController::class, 'rate'])->middleware('auth:sanctum');
Route::get('/restaurant/{restaurant}/user-rating', [RatingController::class, 'getUserRating'])->middleware('auth:sanctum');
Route::delete('/restaurant/{restaurant}/unrate', [RatingController::class, 'unrate'])->middleware('auth:sanctum');


//review

Route::post('/review-restaurant/{restaurant}', [RatingController::class, 'addReview'])->middleware('auth:sanctum');
Route::get('/restaurant/{restaurant}/user-review', [RatingController::class, 'getReview'])->middleware('auth:sanctum');
Route::delete('/restaurant/{restaurant}/delete-review', [RatingController::class, 'removeReview'])->middleware('auth:sanctum');






//view menu

Route::post('/restaurant/{restaurant}/menu/view', [MenuController::class, 'viewRestaurantMenu']);

//view menu (we are using this one)

Route::get('/restaurant/{restaurant}/menu/{menu}', [MenuController::class, 'viewRestaurantMen']);






//virtual tour

Route::get('/restaurant/{restaurant}/tour', [RestaurantController::class, 'getRestaurantTour']);






//offers

Route::get('/restaurant/{restaurant}/offers', [OfferController::class, 'getRestaurantOffers']);
Route::get('/offers/featured', [OfferController::class, 'getFeaturedOffers']);





//send notification to logged in user

Route::middleware('auth:sanctum')->post('/send-notification', function (Request $request) {
    
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

 
    $request->validate([
        'message' => 'required|string',
    ]);

    // Send notification to the logged-in user
    $user->notify(new CustomNotification([
        'message' => $request->input('message'),
    ]));

    return response()->json([
        'status' => 'Notification sent successfully',
        'user' => $user->name, // Optional: Show who received the notification
    ]);
});






//testing if user is logged in

Route::middleware('auth:sanctum')->get('/test-auth', function () {
    return response()->json(Auth::user());
});






//get the logged in user notifications

Route::middleware('auth:sanctum')->get('/notifications', function () {
    if (!Auth::check()) {
        return response()->json([
            'error' => 'Unauthorized access. Please log in to retrieve notifications.'
        ], 401);
    }

    return response()->json([
        'notifications' => Auth::user()->notifications,
        'message' => 'Notifications retrieved successfully.'
    ]);
});






//manager views rating and review feedback from customers

Route::middleware(['auth:sanctum'])->get('/manager/ratings-reviews', [ManagerController::class, 'getRatingsAndReviews'])->middleware(RoleMiddleware::class.':3');





// reserve
Route::post('/restaurant/{restaurant}/reserve', [CustomerController::class, 'reserveTable'])
    ->middleware(['auth:sanctum', RoleMiddleware::class . ':1'])->name('dashboard.customer');



//event book
Route::post('/restaurant/{restaurant}/book-event', [CustomerController::class, 'bookEvent'])
    ->middleware(['auth:sanctum', RoleMiddleware::class . ':1'])->name('dashboard.customer');



Route::middleware(['auth:sanctum'])->get('/customer/reservations', function () {
    return response()->json(Auth::user()->reservations)->middleware(RoleMiddleware::class.':1');
});
