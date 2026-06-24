<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $bids = $user->bids()
            ->with(['auction.category'])
            ->latest()
            ->take(20)
            ->get();

        $stats = [
            'total_bids' => $user->bids()->count(),
            'winning_bids' => $user->winningBids()->count(),
            'active_bids' => $user->bids()
                ->where('is_winning', true)
                ->whereHas('auction', fn ($q) => $q->live())
                ->count(),
        ];

        return view('profile.show', compact('user', 'bids', 'stats'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        if (isset($validated['avatar'])) {
            $user->avatar = $validated['avatar'];
        }

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
