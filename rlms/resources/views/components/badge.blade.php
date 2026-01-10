@props(['status' => 'default', 'size' => 'md'])

@php
    $classes = match($status) {
        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
        'approved', 'active', 'available', 'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
        'rejected', 'banned', 'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
        'suspended', 'maintenance', 'in_progress' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300',
        'retired', 'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-sm',
        'lg' => 'px-3 py-1.5 text-base',
        default => 'px-2.5 py-1 text-sm',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full $classes $sizeClasses"]) }}>
    {{ $slot }}
</span>
