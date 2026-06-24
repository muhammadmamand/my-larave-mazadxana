<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = Auction::with('category')
            ->featured()
            ->live()
            ->orderByDesc('current_price')
            ->take(5)
            ->get();

        if ($heroSlides->count() < 3) {
            $heroSlides = Auction::with('category')
                ->live()
                ->orderByDesc('current_price')
                ->take(5)
                ->get();
        }

        $featuredAuctions = Auction::with('category')
            ->featured()
            ->live()
            ->orderByDesc('current_price')
            ->take(3)
            ->get();

        $liveAuctions = Auction::with('category')
            ->live()
            ->orderBy('ends_at')
            ->take(8)
            ->get();

        $endingSoon = Auction::with('category')
            ->endingSoon()
            ->take(4)
            ->get();

        $stats = [
            'live_auctions' => Auction::live()->count(),
            'total_bids' => Auction::sum('bid_count'),
            'categories' => Category::count(),
        ];

        return view('home', compact(
            'heroSlides',
            'featuredAuctions',
            'liveAuctions',
            'endingSoon',
            'stats'
        ));
    }
}
