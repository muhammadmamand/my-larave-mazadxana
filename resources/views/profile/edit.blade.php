@extends('layouts.app')

@section('title', 'Edit Profile — MazadXA')

@section('content')
    <div class="page-container py-8 sm:py-12">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6 sm:mb-8">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-amber-600 dark:hover:text-amber-400 transition-colors mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Back to Profile
                </a>
                <h1 class="section-title">Edit <span class="gradient-text">Profile</span></h1>
            </div>

            <div class="glass-strong rounded-2xl sm:rounded-3xl p-6 sm:p-8">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-subtle">
                        <x-user-avatar :user="$user" size="xl" />
                        <div class="flex-1 w-full">
                            <label for="avatar" class="block text-sm font-medium text-subtle mb-2">Profile Photo</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*"
                                   class="block w-full text-sm text-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                          file:bg-amber-500/15 file:text-amber-700 dark:file:text-amber-400 file:font-medium file:cursor-pointer">
                            @error('avatar')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-subtle mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-subtle mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-subtle mb-2">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field" placeholder="Optional">
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="bio" class="block text-sm font-medium text-subtle mb-2">Bio</label>
                            <textarea id="bio" name="bio" rows="3" class="input-field resize-none"
                                      placeholder="Tell other bidders a little about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-subtle space-y-4">
                        <h3 class="font-semibold text-heading">Change Password</h3>
                        <p class="text-sm text-muted">Leave blank to keep your current password.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-subtle mb-2">New Password</label>
                                <input type="password" id="password" name="password" class="input-field">
                                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-subtle mb-2">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col xs:flex-row gap-3 pt-2">
                        <button type="submit" class="btn-primary flex-1">Save Changes</button>
                        <a href="{{ route('profile.show') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
