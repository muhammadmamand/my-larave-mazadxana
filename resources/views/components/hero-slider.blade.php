@if($heroSlides->count())
<section class="hero-slider" data-hero-slider data-autoplay="6000">
    <div class="hero-slider-inner">
        @foreach($heroSlides as $index => $slide)
            <article class="hero-slide {{ $index === 0 ? 'is-active' : '' }}" data-hero-slide data-index="{{ $index }}">
                <img src="{{ $slide->image }}"
                     alt="{{ $slide->title }}"
                     class="hero-slide-bg"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                <div class="hero-slide-overlay"></div>

                <div class="page-container hero-slide-content">
                    <div class="max-w-3xl">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                            <span class="badge-live">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Live Auction
                            </span>
                            @if($slide->featured)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500 text-slate-950">Featured</span>
                            @endif
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-white/10 text-white/90 backdrop-blur">
                                {{ $slide->category->icon }} {{ $slide->category->name }}
                            </span>
                        </div>

                        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight mb-4 sm:mb-6">
                            {{ $slide->title }}
                        </h2>

                        <p class="text-sm sm:text-base md:text-lg text-slate-300 leading-relaxed line-clamp-2 sm:line-clamp-3 mb-6 sm:mb-8 max-w-2xl">
                            {{ Str::limit($slide->description, 160) }}
                        </p>

                        <div class="flex flex-wrap items-center gap-4 sm:gap-8 mb-6 sm:mb-8">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-slate-400 mb-1">Current Bid</p>
                                <p class="text-2xl sm:text-3xl md:text-4xl font-extrabold gradient-text">
                                    ${{ number_format($slide->current_price, 0) }}
                                </p>
                            </div>
                            <div class="hidden sm:block w-px h-12 bg-white/20"></div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-slate-400 mb-1">Ends In</p>
                                <p class="text-lg sm:text-xl font-bold text-amber-400 font-mono"
                                   data-countdown="{{ $slide->ends_at->toIso8601String() }}">
                                    {{ $slide->timeRemaining() }}
                                </p>
                            </div>
                            <div class="hidden md:block w-px h-12 bg-white/20"></div>
                            <div class="hidden md:block">
                                <p class="text-xs uppercase tracking-wider text-slate-400 mb-1">Bids</p>
                                <p class="text-lg sm:text-xl font-bold text-white">{{ $slide->bid_count }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col xs:flex-row gap-3 sm:gap-4">
                            <a href="{{ route('auctions.show', $slide) }}" class="btn-primary w-full xs:w-auto">
                                Place Bid
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('auctions.show', $slide) }}" class="btn-secondary w-full xs:w-auto !bg-white/10 !border-white/20 !text-white hover:!bg-white/20">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach

        {{-- Side arrows --}}
        @if($heroSlides->count() > 1)
            <button type="button" data-hero-prev class="hero-slider-arrow absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 z-30 hidden sm:flex" aria-label="Previous slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button type="button" data-hero-next class="hero-slider-arrow absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 z-30 hidden sm:flex" aria-label="Next slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        @endif
    </div>

    @if($heroSlides->count() > 1)
        <div class="hero-slider-nav">
            <div class="page-container flex items-center justify-between gap-4">
                <div class="flex items-center gap-2" data-hero-dots>
                    @foreach($heroSlides as $index => $slide)
                        <button type="button"
                                class="hero-slider-dot {{ $index === 0 ? 'is-active' : '' }}"
                                data-hero-dot="{{ $index }}"
                                aria-label="Go to slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <p class="text-xs sm:text-sm text-white/60 font-medium tabular-nums" data-hero-counter>
                    <span data-hero-current>1</span> / {{ $heroSlides->count() }}
                </p>
            </div>
        </div>
    @endif
</section>

{{-- Stats strip below slider --}}
<div class="hero-stats-bar">
    <div class="page-container py-5 sm:py-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div class="flex items-center gap-2 glass rounded-full px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm w-fit">
                <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse shrink-0"></span>
                <span class="text-subtle">{{ $stats['live_auctions'] }} live auctions right now</span>
            </div>
            <div class="grid grid-cols-3 gap-4 sm:flex sm:items-center sm:gap-8 lg:gap-12">
                <div class="text-center sm:text-left">
                    <p class="text-xl sm:text-2xl font-bold gradient-text">{{ number_format($stats['total_bids']) }}+</p>
                    <p class="text-xs sm:text-sm text-slate-500">Total Bids</p>
                </div>
                <div class="hidden sm:block w-px h-10 bg-slate-200 dark:bg-white/10"></div>
                <div class="text-center sm:text-left">
                    <p class="text-xl sm:text-2xl font-bold gradient-text">{{ $stats['categories'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-500">Categories</p>
                </div>
                <div class="hidden sm:block w-px h-10 bg-slate-200 dark:bg-white/10"></div>
                <div class="text-center sm:text-left">
                    <p class="text-xl sm:text-2xl font-bold gradient-text">{{ $stats['live_auctions'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-500">Live Now</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
