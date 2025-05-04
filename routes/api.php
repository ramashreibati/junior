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


