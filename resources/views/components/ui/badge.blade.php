@props([
    'variant' => 'default', // default, primary, success, warning, danger, info
    'size' => 'md', // sm, md, lg
    'dot' => false,
])

@php
$variants = [
    'default' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300',
    'primary' => 'bg-accent-indigo/10 text-accent-indigo',
    'success' => 'bg-accent-emerald/10 text-accent-emerald',
    'warning' => 'bg-accent-amber/10 text-accent-amber',
    'danger' => 'bg-accent-rose/10 text-accent-rose',
    'info' => 'bg-accent-cyan/10 text-accent-cyan',
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-xs',
    'lg' => 'px-3 py-1.5 text-sm',
];

$classes = 'inline-flex items-center gap-1.5 font-medium rounded-full ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
    @endif
    {{ $slot }}
</span>
