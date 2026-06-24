<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        if ($auction->isEnded()) {
            return back()->with('error', 'This auction has ended.');
        }

        $minimum = $auction->minimumBid();
        $user = Auth::user();

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:'.$minimum],
        ], [
            'amount.min' => 'Your bid must be at least $'.number_format($minimum, 2).'.',
        ]);

        Bid::where('auction_id', $auction->id)->update(['is_winning' => false]);

        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $user->id,
            'bidder_name' => $user->name,
            'bidder_email' => $user->email,
            'amount' => $validated['amount'],
            'is_winning' => true,
        ]);

        $auction->update([
            'current_price' => $validated['amount'],
            'bid_count' => $auction->bid_count + 1,
        ]);

        return back()->with('success', 'Your bid of $'.number_format($validated['amount'], 2).' was placed successfully!');
    }
}
