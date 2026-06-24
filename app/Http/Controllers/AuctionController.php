<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auction::with('category')->live();

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'ending');
        $query = match ($sort) {
            'price_low' => $query->orderBy('current_price'),
            'price_high' => $query->orderByDesc('current_price'),
            'bids' => $query->orderByDesc('bid_count'),
            'newest' => $query->orderByDesc('created_at'),
            default => $query->orderBy('ends_at'),
        };

        $auctions = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('liveAuctions')->orderBy('name')->get();

        return view('auctions.index', compact('auctions', 'categories'));
    }

    public function show(Auction $auction)
    {
        $auction->load(['category', 'bids' => fn ($q) => $q->take(10)]);

        $related = Auction::with('category')
            ->live()
            ->where('category_id', $auction->category_id)
            ->where('id', '!=', $auction->id)
            ->take(4)
            ->get();

        return view('auctions.show', compact('auction', 'related'));
    }
}
