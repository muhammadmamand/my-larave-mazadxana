@extends('layouts.app')

@section('title', 'My Profile — MazadXA')

@section('content')
    <div class="page-container py-8 sm:py-12">
        {{-- Profile Header --}}
        <div class="glass-strong rounded-2xl sm:rounded-3xl p-6 sm:p-8 mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <x-user-avatar :user="$user" size="xl" />

                <div class="flex-1 text-center sm:text-left min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-heading mb-1">{{ $user->name }}</h1>
                    <p class="text-muted text-sm sm:text-base mb-1">{{ $user->email }}</p>
                    @if($user->phone)
                        <p class="text-muted text-sm">{{ $user->phone }}</p>
                    @endif
                    @if($user->bio)
                        <p class="text-subtle text-sm sm:text-base mt-4 max-w-xl">{{ $user->bio }}</p>
                    @endif
                </div>

                <div class="flex flex-col xs:flex-row sm:flex-col gap-2 w-full sm:w-auto shrink-0">
                    <a href="{{ route('profile.edit') }}" class="btn-secondary text-center !py-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-secondary w-full !py-2.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 sm:gap-6 mb-6 sm:mb-8">
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <p class="text-2xl sm:text-3xl font-bold gradient-text">{{ $stats['total_bids'] }}</p>
                <p class="text-xs sm:text-sm text-muted mt-1">Total Bids</p>
            </div>
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <p class="text-2xl sm:text-3xl font-bold gradient-text">{{ $stats['winning_bids'] }}</p>
                <p class="text-xs sm:text-sm text-muted mt-1">Winning Bids</p>
            </div>
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <p class="text-2xl sm:text-3xl font-bold gradient-text">{{ $stats['active_bids'] }}</p>
                <p class="text-xs sm:text-sm text-muted mt-1">Active Leading</p>
            </div>
        </div>

        {{-- Bid History --}}
        <div class="glass rounded-2xl sm:rounded-3xl p-5 sm:p-8">
            <h2 class="text-xl font-bold text-heading mb-6">My <span class="gradient-text">Bids</span></h2>

            @if($bids->count())
                <div class="space-y-3">
                    @foreach($bids as $bid)
                        <a href="{{ route('auctions.show', $bid->auction) }}"
                           class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 p-4 rounded-xl border border-subtle
                                  hover:border-amber-500/30 hover:bg-slate-50/50 dark:hover:bg-white/5 transition-all group">
                            <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-white/5">
                                    @if($bid->auction->image)
                                        <img src="{{ $bid->auction->image }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-heading group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors line-clamp-1">
                                        {{ $bid->auction->title }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-muted">{{ $bid->auction->category->name }} · {{ $bid->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-4 sm:text-right shrink-0 pl-[4.25rem] sm:pl-0">
                                <p class="font-mono font-bold text-heading">${{ number_format($bid->amount, 2) }}</p>
                                @if($bid->is_winning && $bid->auction->isLive())
                                    <span class="badge-live text-[10px] sm:text-xs">Leading</span>
                                @elseif($bid->is_winning)
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-700 dark:text-amber-400">Won</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="text-muted mb-4">You haven't placed any bids yet.</p>
                    <a href="{{ route('auctions.index') }}" class="btn-primary">Browse Auctions</a>
                </div>
            @endif
        </div>
    </div>
@endsection
