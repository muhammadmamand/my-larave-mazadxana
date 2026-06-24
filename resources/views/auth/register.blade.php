@extends('layouts.app')

@section('title', 'Register — MazadXA')

@section('content')
    <div class="page-container py-10 sm:py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="section-title mb-2">Join <span class="gradient-text">MazadXA</span></h1>
                <p class="text-muted text-sm sm:text-base">Create your account and start bidding on exclusive items.</p>
            </div>

            <div class="glass-strong rounded-2xl sm:rounded-3xl p-6 sm:p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-subtle mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="input-field" placeholder="John Doe" required autofocus>
                        @error('name')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-subtle mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="input-field" placeholder="you@email.com" required>
                        @error('email')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-subtle mb-2">Phone <span class="text-slate-400">(optional)</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                               class="input-field" placeholder="+1 234 567 8900">
                        @error('phone')
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

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-subtle mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="input-field" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-primary w-full">Create Account</button>
                </form>

                <p class="text-center text-sm text-muted mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-amber-600 dark:text-amber-400 font-medium hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
