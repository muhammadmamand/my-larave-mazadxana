@extends('layouts.app')

@section('title', $auction->title . ' — MazadXA')

@section('content')
    <div class="page-container py-6 sm:py-8 md:py-12">
        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs sm:text-sm text-slate-500 mb-6 sm:mb-8">
            <a href="{{ route('home') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Home</a>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('auctions.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Auctions</a>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0 hidden xs:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-subtle line-clamp-1 w-full xs:w-auto xs:truncate">{{ $auction->title }}</span>
        </nav>

        <div class="grid lg:grid-cols-5 gap-6 lg:gap-12">
            {{-- Image Gallery --}}
            <div class="lg:col-span-3 min-w-0">
                <div class="glass rounded-2xl sm:rounded-3xl overflow-hidden">
                    <div class="relative aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3]">
                        <img src="{{ $auction->image }}"
                             alt="{{ $auction->title }}"
                             class="w-full h-full object-cover">
                        <div class="absolute top-3 sm:top-4 left-3 sm:left-4 flex flex-wrap items-center gap-2">
                            @if($auction->featured)
                                <span class="px-2.5 sm:px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-slate-950">Featured</span>
                            @endif
                            @if($auction->isLive())
                                <span class="badge-live">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Live Auction
                                </span>
                            @else
                                <span class="px-2.5 sm:px-3 py-1 rounded-full text-xs font-bold bg-slate-200 text-slate-600 dark:bg-slate-500/50 dark:text-slate-300">Ended</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Mobile title & price (shown before description on small screens) --}}
                <div class="lg:hidden mt-4 space-y-3">
                    <span class="inline-block px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                        {{ $auction->category->name }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-heading leading-tight">{{ $auction->title }}</h1>
                    <div class="flex items-end justify-between glass rounded-xl p-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Current Bid</p>
                            <p class="text-2xl sm:text-3xl font-extrabold gradient-text">${{ number_format($auction->current_price, 2) }}</p>
                        </div>
                        @if($auction->isLive())
                            <div class="text-right">
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Ends In</p>
                                <p class="text-base font-bold text-amber-600 dark:text-amber-400 font-mono" data-countdown="{{ $auction->ends_at->toIso8601String() }}">
                                    {{ $auction->timeRemaining() }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="glass rounded-2xl p-5 sm:p-6 md:p-8 mt-4 sm:mt-6">
                    <h2 class="text-lg sm:text-xl font-bold text-heading mb-3 sm:mb-4">Description</h2>
                    <p class="text-muted text-sm sm:text-base leading-relaxed">{{ $auction->description }}</p>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-subtle">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Category</p>
                            <p class="text-sm font-medium text-heading">{{ $auction->category->icon }} {{ $auction->category->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Starting Price</p>
                            <p class="text-sm font-medium text-heading">${{ number_format($auction->starting_price, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Bid Increment</p>
                            <p class="text-sm font-medium text-heading">${{ number_format($auction->bid_increment, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Watchers</p>
                            <p class="text-sm font-medium text-heading">{{ number_format($auction->watchers) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bid Panel --}}
            <div class="lg:col-span-2 min-w-0">
                <div class="glass-strong rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 lg:sticky lg:top-20 xl:top-24">
                    <div class="hidden lg:block">
                        <span class="inline-block px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 dark:bg-white/10 dark:text-slate-300 mb-4">
                            {{ $auction->category->name }}
                        </span>
                        <h1 class="text-2xl md:text-3xl font-bold text-heading mb-6 leading-tight">
                            {{ $auction->title }}
                        </h1>
                    </div>

                    {{-- Price & Timer — desktop --}}
                    <div class="glass rounded-2xl p-4 sm:p-5 mb-5 sm:mb-6 hidden lg:block">
                        <div class="flex items-end justify-between mb-4 gap-4">
                            <div class="min-w-0">
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Current Bid</p>
                                <p class="text-3xl md:text-4xl font-extrabold gradient-text break-all">
                                    ${{ number_format($auction->current_price, 2) }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Bids</p>
                                <p class="text-xl font-bold text-heading">{{ $auction->bid_count }}</p>
                            </div>
                        </div>

                        @if($auction->isLive())
                            <div class="flex items-center justify-between pt-4 border-t border-subtle gap-4">
                                <p class="text-sm text-muted">Time Remaining</p>
                                <p class="text-base sm:text-lg font-bold text-amber-600 dark:text-amber-400 font-mono text-right"
                                   data-countdown="{{ $auction->ends_at->toIso8601String() }}">
                                    {{ $auction->timeRemaining() }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if($auction->isLive())
                        @auth
                            <div class="flex items-center gap-3 mb-4 p-3 rounded-xl bg-slate-50 dark:bg-white/5 border border-subtle">
                                <x-user-avatar :user="auth()->user()" size="md" />
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-heading truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-muted truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            <form action="{{ route('bids.store', $auction) }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-subtle mb-2">
                                        Your Bid <span class="text-slate-500">(min. ${{ number_format($auction->minimumBid(), 2) }})</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">$</span>
                                        <input type="number"
                                               name="amount"
                                               step="0.01"
                                               min="{{ $auction->minimumBid() }}"
                                               value="{{ old('amount', $auction->minimumBid()) }}"
                                               class="input-field !pl-8 font-mono text-base sm:text-lg"
                                               required>
                                    </div>
                                    @error('amount')
                                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="btn-primary w-full !py-3.5 sm:!py-4">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <span class="truncate">Place Bid — ${{ number_format($auction->minimumBid(), 2) }}+</span>
                                </button>
                            </form>

                            <p class="text-xs text-slate-500 text-center mt-4 px-2">
                                By placing a bid, you agree to our terms and conditions.
                            </p>
                        @else
                            <div class="glass rounded-2xl p-6 text-center space-y-4">
                                <div class="w-14 h-14 rounded-2xl bg-amber-500/15 flex items-center justify-center mx-auto">
                                    <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-heading mb-1">Sign in to place a bid</p>
                                    <p class="text-sm text-muted">Create a free account or log in to start bidding on this item.</p>
                                </div>
                                <div class="flex flex-col xs:flex-row gap-2 justify-center">
                                    <a href="{{ route('login') }}" class="btn-primary flex-1">Sign In</a>
                                    <a href="{{ route('register') }}" class="btn-secondary flex-1">Register</a>
                                </div>
                            </div>
                        @endauth
                    @else
                        <div class="glass rounded-xl p-4 text-center">
                            <p class="text-muted">This auction has ended.</p>
                            @if($auction->winningBid())
                                <p class="text-heading font-semibold mt-2">
                                    Winning bid: ${{ number_format($auction->winningBid()->amount, 2) }}
                                </p>
                            @endif
                        </div>
                    @endif

                    {{-- Recent Bids --}}
                    @if($auction->bids->count())
                        <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-subtle">
                            <h3 class="font-semibold text-heading mb-4">Recent Bids</h3>
                            <div class="space-y-3 max-h-48 overflow-y-auto pr-1">
                                @foreach($auction->bids as $bid)
                                    <div class="flex items-center justify-between gap-2 text-sm {{ $bid->is_winning ? 'text-amber-600 dark:text-amber-400' : 'text-muted' }}">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($bid->bidder_name, 0, 1)) }}
                                            </div>
                                            <span class="truncate">{{ $bid->bidder_name }}</span>
                                            @if($bid->is_winning)
                                                <span class="text-xs bg-amber-500/15 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 px-2 py-0.5 rounded-full shrink-0 hidden sm:inline">Leading</span>
                                            @endif
                                        </div>
                                        <span class="font-mono font-medium shrink-0">${{ number_format($bid->amount, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Related Auctions --}}
        @if($related->count())
            <section class="mt-12 sm:mt-20">
                <h2 class="section-title mb-6 sm:mb-8">Related <span class="gradient-text">Auctions</span></h2>
                <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6">
                    @foreach($related as $item)
                        <x-auction-card :auction="$item" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
