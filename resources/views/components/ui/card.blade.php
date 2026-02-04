@props([
    'padding' => 'default', // none, sm, default, lg
    'hover' => false,
])

@php
$baseClasses = 'glass-card rounded-2xl';

$paddings = [
    'none' => '',
    'sm' => 'p-4',
    'default' => 'p-5 lg:p-6',
    'lg' => 'p-6 lg:p-8',
];

$hoverClass = $hover ? 'hover:glass-card-hover transition-all cursor-pointer' : '';

$classes = $baseClasses . ' ' . $paddings[$padding] . ' ' . $hoverClass;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
