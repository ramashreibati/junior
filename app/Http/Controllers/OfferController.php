<?php

namespace App\Http\Controllers;
use App\Models\Restaurants;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function getRestaurantOffers(Restaurants $restaurant)
    {
        $offers = Offer::where('restaurants_id', $restaurant->id)
                    ->where('valid_until', '>=', now()) // Only active offers
                    ->orderBy('valid_until', 'desc')
                    ->get();

        return response()->json($offers);
    }

    public function getFeaturedOffers()
    {
        $featuredOffers = Offer::where('is_featured', true)
                            ->where('valid_until', '>=', now())
                            ->orderBy('valid_until', 'desc')
                            ->get();

        return response()->json($featuredOffers);
    }


}
