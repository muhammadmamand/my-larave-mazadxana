@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-16 h-16 text-xl',
        'xl' => 'w-24 h-24 text-3xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $avatarUrl = $user->avatarUrl();
@endphp

@if($avatarUrl)
    <img src="{{ $avatarUrl }}"
         alt="{{ $user->name }}"
         class="{{ $sizeClass }} rounded-full object-cover ring-2 ring-amber-500/30 shrink-0">
@else
    <div class="{{ $sizeClass }} rounded-full bg-gradient-to-br from-amber-400 to-orange-500
                flex items-center justify-center font-bold text-slate-950 ring-2 ring-amber-500/30 shrink-0">
        {{ $user->initials() }}
    </div>
@endif
