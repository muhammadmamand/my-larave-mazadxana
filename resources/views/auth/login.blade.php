@extends('layouts.app')

@section('title', 'Login — MazadXA')

@section('content')
    <div class="page-container py-10 sm:py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="section-title mb-2">Welcome <span class="gradient-text">Back</span></h1>
                <p class="text-muted text-sm sm:text-base">Sign in to bid, track auctions, and manage your profile.</p>
            </div>

            <div class="glass-strong rounded-2xl sm:rounded-3xl p-6 sm:p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-subtle mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="input-field" placeholder="you@email.com" required autofocus>
                        @error('email')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-subtle mb-2">Password</label>
                        <input type="password" id="password" name="password"
                               class="input-field" placeholder="••••••••" required>
                        @error('password')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500/50">
                        <span class="text-sm text-muted">Remember me</span>
                    </label>

                    <button type="submit" class="btn-primary w-full">Sign In</button>
                </form>

                <p class="text-center text-sm text-muted mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-amber-600 dark:text-amber-400 font-medium hover:underline">Create one</a>
                </p>
            </div>
        </div>
    </div>
@endsection
