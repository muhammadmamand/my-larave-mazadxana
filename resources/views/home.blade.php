@extends('layouts.app')

@section('title', 'MazadXA — Premium Digital Auctions')

@section('content')
    <x-hero-slider :hero-slides="$heroSlides" :stats="$stats" />

    {{-- Featured Auctions --}}
    @if($featuredAuctions->count())
        <section class="page-container pb-12 sm:pb-20">
            <div class="section-header">
                <div>
                    <p class="text-amber-600 dark:text-amber-400 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-1 sm:mb-2">Handpicked</p>
                    <h2 class="section-title">Featured <span class="gradient-text">Auctions</span></h2>
                </div>
                <a href="{{ route('auctions.index') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300 font-medium inline-flex items-center gap-1 self-start sm:self-auto">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 sm:gap-6">
                @foreach($featuredAuctions as $auction)
                    <x-auction-card :auction="$auction" :featured="true" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Ending Soon --}}
    @if($endingSoon->count())
        <section class="page-container pb-12 sm:pb-20">
            <div class="section-header">
                <div>
                    <p class="text-red-500 dark:text-red-400 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-1 sm:mb-2">Don't Miss Out</p>
                    <h2 class="section-title">Ending <span class="gradient-text">Soon</span></h2>
                </div>
            </div>
            <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach($endingSoon as $auction)
                    <x-auction-card :auction="$auction" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Live Auctions --}}
    <section class="page-container pb-12 sm:pb-20">
        <div class="section-header">
            <div>
                <p class="text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-1 sm:mb-2">Active Now</p>
                <h2 class="section-title">Live <span class="gradient-text">Auctions</span></h2>
            </div>
            <a href="{{ route('auctions.index') }}" class="btn-secondary !py-2 !px-4 self-start sm:self-auto">See All</a>
        </div>
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6">
            @foreach($liveAuctions as $auction)
                <x-auction-card :auction="$auction" />
            @endforeach
        </div>
    </section>
@endsection
