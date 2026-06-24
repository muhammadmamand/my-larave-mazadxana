<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="MazadXA — Premium digital auction platform. Bid on luxury items, collectibles, and more.">

    <title>@yield('title', 'MazadXA — Digital Auctions')</title>

    <script>
        (function () {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if ((stored ?? (prefersDark ? 'dark' : 'light')) === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    <div class="fixed inset-0 bg-grid pointer-events-none -z-10"></div>
    <div class="fixed inset-0 hero-glow pointer-events-none -z-10"></div>

    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 glass border-b border-subtle backdrop-blur-xl bg-white/90 dark:bg-slate-950/85">
        <div class="page-container">
            <div class="flex items-center justify-between h-14 sm:h-16 md:h-20 gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group min-w-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-105 transition-transform shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-950" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="text-lg sm:text-xl font-bold text-heading truncate">
                        Mazad<span class="gradient-text">XA</span>
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-6 lg:gap-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">Home</a>
                    <a href="{{ route('auctions.index') }}" class="nav-link {{ request()->routeIs('auctions.*') ? 'nav-link-active' : '' }}">Auctions</a>
                    <a href="{{ route('auctions.index', ['sort' => 'ending']) }}" class="nav-link">Ending Soon</a>
                </div>

                <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                    <button type="button" data-theme-toggle class="btn-icon !w-9 !h-9 sm:!w-10 sm:!h-10" aria-label="Toggle theme">
                        <svg data-theme-icon="sun" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg data-theme-icon="moon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    @auth
                        <div class="nav-auth-group">
                            <a href="{{ route('profile.show') }}" class="hidden sm:flex items-center gap-2 btn-secondary !py-2 !px-3">
                                <x-user-avatar :user="auth()->user()" size="sm" />
                                <span class="max-w-[120px] truncate text-sm">{{ auth()->user()->name }}</span>
                            </a>
                            <a href="{{ route('profile.show') }}" class="sm:hidden btn-icon !w-9 !h-9 p-0 overflow-hidden" aria-label="Profile">
                                <x-user-avatar :user="auth()->user()" size="sm" />
                            </a>
                        </div>
                    @else
                        <div class="nav-auth-group">
                            <a href="{{ route('login') }}" class="btn-nav-login">
                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Log in</span>
                                <span class="sm:hidden text-xs font-semibold">Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="btn-nav-register">
                                <span class="hidden sm:inline">Sign up</span>
                                <span class="sm:hidden text-xs font-semibold">Join</span>
                            </a>
                        </div>
                    @endauth

                    <button type="button"
                            data-mobile-menu-open
                            class="btn-icon md:hidden"
                            aria-label="Open menu"
                            aria-expanded="false"
                            aria-controls="mobile-menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div id="mobile-menu-backdrop"
         class="fixed inset-0 z-[60] bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"
         data-mobile-menu-close
         aria-hidden="true"></div>

    <div id="mobile-menu"
         class="fixed top-0 right-0 z-[70] h-full w-full max-w-xs sm:max-w-sm glass-strong border-l border-subtle
                translate-x-full transition-transform duration-300 ease-out md:hidden safe-bottom flex flex-col"
         aria-hidden="true">
        <div class="flex items-center justify-between p-4 border-b border-subtle">
            <span class="font-bold text-heading">Menu</span>
            <button type="button" data-mobile-menu-close class="btn-icon" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <a href="{{ route('home') }}" data-mobile-menu-link
               class="mobile-menu-link {{ request()->routeIs('home') ? 'mobile-menu-link-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </a>
            <a href="{{ route('auctions.index') }}" data-mobile-menu-link
               class="mobile-menu-link {{ request()->routeIs('auctions.*') ? 'mobile-menu-link-active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                All Auctions
            </a>
            <a href="{{ route('auctions.index', ['sort' => 'ending']) }}" data-mobile-menu-link class="mobile-menu-link">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Ending Soon
            </a>
            @auth
                <a href="{{ route('profile.show') }}" data-mobile-menu-link class="mobile-menu-link {{ request()->routeIs('profile.*') ? 'mobile-menu-link-active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    My Profile
                </a>
            @else
                <a href="{{ route('login') }}" data-mobile-menu-link class="mobile-menu-link {{ request()->routeIs('login') ? 'mobile-menu-link-active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Login
                </a>
                <a href="{{ route('register') }}" data-mobile-menu-link class="mobile-menu-link {{ request()->routeIs('register') ? 'mobile-menu-link-active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Register
                </a>
            @endauth
        </nav>

        <div class="p-4 border-t border-subtle space-y-2">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" data-mobile-menu-link class="btn-secondary w-full !text-red-600 dark:!text-red-400">Log Out</button>
                </form>
            @else
                <a href="{{ route('auctions.index') }}" data-mobile-menu-link class="btn-primary w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Start Bidding
                </a>
            @endauth
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="page-container mt-3 sm:mt-4">
            <div class="glass rounded-xl px-4 py-3 border-emerald-500/30 bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 flex items-start sm:items-center gap-2 text-sm sm:text-base">
                <svg class="w-5 h-5 shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="page-container mt-3 sm:mt-4">
            <div class="glass rounded-xl px-4 py-3 border-red-500/30 bg-red-500/10 text-red-700 dark:text-red-300 flex items-start sm:items-center gap-2 text-sm sm:text-base">
                <svg class="w-5 h-5 shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="flex-1 w-full min-w-0">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-subtle mt-12 sm:mt-20">
        <div class="page-container py-8 sm:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="sm:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-slate-950" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-heading">Mazad<span class="gradient-text">XA</span></span>
                    </div>
                    <p class="text-muted text-sm leading-relaxed max-w-md">
                        The premier digital auction platform. Discover exclusive items, place competitive bids, and win extraordinary treasures from around the world.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-heading mb-3 sm:mb-4">Explore</h4>
                    <ul class="space-y-2 text-sm text-muted">
                        <li><a href="{{ route('auctions.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors inline-block py-1">All Auctions</a></li>
                        <li><a href="{{ route('auctions.index', ['sort' => 'ending']) }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors inline-block py-1">Ending Soon</a></li>
                        <li><a href="{{ route('auctions.index', ['sort' => 'price_high']) }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors inline-block py-1">Premium Items</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-heading mb-3 sm:mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-muted">
                        <li><a href="#" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors inline-block py-1">How to Bid</a></li>
                        <li><a href="#" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors inline-block py-1">Buyer Protection</a></li>
                        <li><a href="#" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors inline-block py-1">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-subtle mt-8 pt-6 sm:pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
                <p class="text-sm text-slate-500">&copy; {{ date('Y') }} MazadXA. All rights reserved.</p>
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-sm text-slate-500">
                    <span>Secure Bidding</span>
                    <span class="w-1 h-1 rounded-full bg-slate-400 dark:bg-slate-600"></span>
                    <span>Verified Sellers</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
