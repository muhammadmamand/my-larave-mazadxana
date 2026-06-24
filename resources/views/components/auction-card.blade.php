@props(['auction', 'featured' => false])

@php
    $endingSoon = $auction->ends_at->diffInHours(now()) < 24;
@endphp

<a href="{{ route('auctions.show', $auction) }}"
   class="group block glass rounded-xl sm:rounded-2xl overflow-hidden card-glow transition-all duration-500 hover:border-amber-500/30 h-full {{ $featured ? 'md:col-span-1' : '' }}">

    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ $auction->image }}"
             alt="{{ $auction->title }}"
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
             loading="lazy">

        <div class="absolute inset-0 image-overlay"></div>

        <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-wrap items-center gap-1.5 sm:gap-2 max-w-[75%]">
            @if($auction->featured)
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-amber-500 text-slate-950">Featured</span>
            @endif
            @if($endingSoon)
                <span class="badge-ending text-[10px] sm:text-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 dark:bg-red-400 animate-pulse"></span>
                    <span class="hidden xs:inline">Ending Soon</span>
                    <span class="xs:hidden">Soon</span>
                </span>
            @else
                <span class="badge-live text-[10px] sm:text-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                    Live
                </span>
            @endif
        </div>

        <div class="absolute top-2 sm:top-3 right-2 sm:right-3 glass rounded-lg px-1.5 sm:px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs text-white flex items-center gap-1">
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            {{ number_format($auction->watchers) }}
        </div>

        <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3 right-2 sm:right-3">
            <span class="inline-block px-2 py-0.5 rounded-md text-[10px] sm:text-xs font-medium bg-black/40 backdrop-blur text-white truncate max-w-full">
                {{ $auction->category->icon }} {{ $auction->category->name }}
            </span>
        </div>
    </div>

    <div class="p-4 sm:p-5">
        <h3 class="font-semibold text-heading group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors line-clamp-2 mb-3 text-sm sm:text-base {{ $featured ? 'sm:text-lg' : '' }}">
            {{ $auction->title }}
        </h3>

        <div class="flex items-end justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs text-slate-500 uppercase tracking-wider mb-0.5 sm:mb-1">Current Bid</p>
                <p class="text-lg sm:text-xl font-bold gradient-text truncate">${{ number_format($auction->current_price, 0) }}</p>
            </div>
            <div class="text-right shrink-0">
                <p class="text-[10px] sm:text-xs text-slate-500 uppercase tracking-wider mb-0.5 sm:mb-1">Time Left</p>
                <p class="text-xs sm:text-sm font-semibold {{ $endingSoon ? 'text-red-500 dark:text-red-400' : 'text-subtle' }}"
                   data-countdown="{{ $auction->ends_at->toIso8601String() }}">
                    {{ $auction->timeRemaining() }}
                </p>
            </div>
        </div>

        <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-subtle flex items-center justify-between text-[10px] sm:text-xs text-slate-500">
            <span>{{ $auction->bid_count }} bids</span>
            <span class="text-amber-600 dark:text-amber-400 font-medium group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                Place Bid
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </div>
    </div>
</a>
