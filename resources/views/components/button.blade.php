@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'icon' => null])

@php
    $classes = match($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white border-transparent',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white border-transparent',
        'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white border-transparent',
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white border-transparent',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 text-white border-transparent',
        'outline' => 'bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800 focus:ring-gray-500 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600',
        'ghost' => 'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 focus:ring-gray-500 text-gray-700 dark:text-gray-300 border-transparent',
        default => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white border-transparent',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "inline-flex items-center justify-center font-medium rounded-lg border focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed $classes $sizeClasses"]) }}>
    @if($icon)
        <span class="{{ $slot->isEmpty() ? '' : (app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2') }}">
            {!! $icon !!}
        </span>
    @endif
    {{ $slot }}
</button>
