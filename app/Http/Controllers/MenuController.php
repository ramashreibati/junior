<?php

namespace App\Http\Controllers;

use App\Models\Restaurants;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItems;

class MenuController extends Controller
{
    


    public function viewRestaurantMen(Restaurants $restaurant, Menu $menu)
{
    // Ensure the menu belongs to the restaurant
    if ($menu->restaurants_id !== $restaurant->id) {
        return response()->json(['message' => 'This menu does not belong to the selected restaurant'], 404);
    }

    // Retrieve the menu along with its items
    $menu->load('menuItems'); // Load related menu items

    return response()->json($menu);
}

    
    

}
