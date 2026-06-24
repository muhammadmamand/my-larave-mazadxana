@extends('layouts.app')

@section('title', 'Browse Auctions — MazadXA')

@section('content')
    <div class="page-container py-8 sm:py-10 md:py-12">
        {{-- Header --}}
        <div class="mb-6 sm:mb-10">
            <h1 class="section-title mb-2 sm:mb-3">Browse <span class="gradient-text">Auctions</span></h1>
            <p class="text-muted text-sm sm:text-base">Find your next winning bid from our curated collection.</p>
        </div>

        {{-- Mobile category chips --}}
        <div class="lg:hidden mb-6 -mx-4 px-4">
            <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                <a href="{{ route('auctions.index', request()->except('category')) }}"
                   class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border transition-colors {{ !request('category') ? 'bg-amber-500/15 text-amber-700 border-amber-500/30 dark:bg-amber-500/20 dark:text-amber-400' : 'glass text-subtle' }}">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('auctions.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
                       class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border transition-colors whitespace-nowrap {{ request('category') === $category->slug ? 'bg-amber-500/15 text-amber-700 border-amber-500/30 dark:bg-amber-500/20 dark:text-amber-400' : 'glass text-subtle' }}">
                        {{ $category->icon }} {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            {{-- Sidebar Filters — desktop only --}}
            <aside class="hidden lg:block lg:w-64 shrink-0">
                <div class="glass rounded-2xl p-5 sm:p-6 sticky top-24">
                    <h3 class="font-semibold text-heading mb-4">Categories</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('auctions.index', request()->except('category')) }}"
                               class="filter-link {{ !request('category') ? 'filter-link-active' : '' }}">
                                All Categories
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('auctions.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
                                   class="filter-link {{ request('category') === $category->slug ? 'filter-link-active' : '' }}">
                                    <span class="truncate mr-2">{{ $category->icon }} {{ $category->name }}</span>
                                    <span class="text-xs text-slate-500 shrink-0">{{ $category->live_auctions_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- Main Content --}}
            <div class="flex-1 min-w-0">
                @php
                    $currentSort = request('sort', 'ending');
                    $sortOptions = [
                        'ending' => ['label' => 'Ending Soon', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'price_low' => ['label' => 'Price ↑', 'icon' => 'M7 11l5-5m0 0l5 5m-5-5v12'],
                        'price_high' => ['label' => 'Price ↓', 'icon' => 'M17 13l-5 5m0 0l-5-5m5 5V6'],
                        'bids' => ['label' => 'Most Bids', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                        'newest' => ['label' => 'Newest', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
                    ];
                @endphp

                {{-- Search & Sort Toolbar --}}
                <div class="search-toolbar mb-5 sm:mb-8">
                    <div class="search-toolbar-glow"></div>

                    <div class="relative p-4 sm:p-5 md:p-6">
                        {{-- Search row --}}
                        <form action="{{ route('auctions.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                            @foreach(request()->except(['search', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach

                            <div class="search-input-wrap flex-1">
                                <svg class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400 dark:text-slate-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Search watches, cars, art, electronics..."
                                       autocomplete="off">
                            </div>

                            <button type="submit" class="search-submit-btn w-full sm:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Search
                            </button>
                        </form>

                        {{-- Divider --}}
                        <div class="flex items-center gap-3 my-4 sm:my-5">
                            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent dark:via-white/10"></div>
                            <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Sort by</span>
                            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent dark:via-white/10"></div>
                        </div>

                        {{-- Sort pills --}}
                        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide sm:flex-wrap sm:overflow-visible">
                            @foreach($sortOptions as $value => $option)
                                <a href="{{ route('auctions.index', array_merge(request()->except('sort'), ['sort' => $value])) }}"
                                   class="sort-pill {{ $currentSort === $value ? 'sort-pill-active' : '' }}"
                                   title="{{ $value === 'price_low' ? 'Price: Low to High' : ($value === 'price_high' ? 'Price: High to Low' : $option['label']) }}">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $option['icon'] }}"/>
                                    </svg>
                                    <span>{{ $option['label'] }}</span>
                                    @if($currentSort === $value)
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 dark:bg-amber-400 shrink-0"></span>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        @if(request('search') || request('category'))
                            <div class="mt-4 pt-4 border-t border-subtle flex flex-wrap items-center gap-2">
                                <span class="text-xs text-muted">Active filters:</span>
                                @if(request('search'))
                                    <a href="{{ route('auctions.index', request()->except(['search', 'page'])) }}"
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-white/10 dark:text-slate-300 dark:hover:bg-white/15 transition-colors">
                                        "{{ request('search') }}"
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </a>
                                @endif
                                @if(request('category'))
                                    @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                                    @if($activeCat)
                                        <a href="{{ route('auctions.index', request()->except(['category', 'page'])) }}"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-500/10 text-amber-700 dark:text-amber-400 hover:bg-amber-500/20 transition-colors">
                                            {{ $activeCat->icon }} {{ $activeCat->name }}
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if($auctions->count())
                    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 sm:gap-6">
                        @foreach($auctions as $auction)
                            <x-auction-card :auction="$auction" />
                        @endforeach
                    </div>

                    <div class="mt-8 sm:mt-10 overflow-x-auto">
                        {{ $auctions->links() }}
                    </div>
                @else
                    <div class="glass rounded-2xl p-8 sm:p-12 text-center">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-slate-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-heading mb-2">No auctions found</h3>
                        <p class="text-muted text-sm sm:text-base mb-6">Try adjusting your search or filters.</p>
                        <a href="{{ route('auctions.index') }}" class="btn-secondary w-full sm:w-auto">Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
