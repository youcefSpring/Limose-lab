@props([
    'variant' => 'primary', // primary, secondary, danger, success, warning, info, ghost
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'href' => null,
    'type' => 'button',
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-all rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-surface-800';

$variants = [
    'primary' => 'bg-gradient-to-r from-accent-indigo to-accent-violet text-white hover:opacity-90 focus:ring-accent-indigo shadow-sm hover:shadow-md',
    'secondary' => 'glass hover:glass-card text-zinc-700 dark:text-zinc-200 focus:ring-accent-indigo',
    'danger' => 'bg-gradient-to-r from-accent-rose to-accent-coral text-white hover:opacity-90 focus:ring-accent-rose shadow-sm hover:shadow-md',
    'success' => 'bg-gradient-to-r from-accent-emerald to-accent-teal text-white hover:opacity-90 focus:ring-accent-emerald shadow-sm hover:shadow-md',
    'warning' => 'bg-gradient-to-r from-accent-amber to-accent-coral text-white hover:opacity-90 focus:ring-accent-amber shadow-sm hover:shadow-md',
    'info' => 'bg-gradient-to-r from-accent-cyan to-accent-teal text-white hover:opacity-90 focus:ring-accent-cyan shadow-sm hover:shadow-md',
    'ghost' => 'hover:bg-black/5 dark:hover:bg-white/5 text-zinc-600 dark:text-zinc-300 focus:ring-accent-indigo',
];

$sizes = [
    'sm' => 'px-3 py-2 text-xs gap-1.5',
    'md' => 'px-4 py-2.5 text-sm gap-2',
    'lg' => 'px-6 py-3 text-base gap-2.5',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-4 h-4" />
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <use href="#icon-{{ $icon }}" />
            </svg>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <use href="#icon-{{ $icon }}" />
            </svg>
        @endif
    </button>
@endif
