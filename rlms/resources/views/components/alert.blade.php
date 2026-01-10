@props(['type' => 'info', 'dismissible' => true, 'title' => null])

@php
    $classes = match($type) {
        'success' => 'bg-green-50 dark:bg-green-900/20 border-green-500 text-green-700 dark:text-green-300',
        'error', 'danger' => 'bg-red-50 dark:bg-red-900/20 border-red-500 text-red-700 dark:text-red-300',
        'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-500 text-yellow-700 dark:text-yellow-300',
        'info' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-500 text-blue-700 dark:text-blue-300',
        default => 'bg-blue-50 dark:bg-blue-900/20 border-blue-500 text-blue-700 dark:text-blue-300',
    };

    $iconPath = match($type) {
        'success' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z',
        'error', 'danger' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z',
        'warning' => 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z',
        'info' => 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z',
        default => 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z',
    };
@endphp

<div @if($dismissible) x-data="{ show: true }" x-show="show" @endif {{ $attributes->merge(['class' => "border-l-4 p-4 rounded-lg $classes"]) }} role="alert">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="{{ $iconPath }}" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="flex-1 {{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}">
            @if($title)
                <h3 class="font-semibold mb-1">{{ $title }}</h3>
            @endif
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <button @click="show = false" type="button" class="flex-shrink-0 {{ app()->getLocale() === 'ar' ? 'mr-auto -ml-1.5' : 'ml-auto -mr-1.5' }} inline-flex h-5 w-5 rounded-lg p-1 hover:bg-black/10 focus:outline-none focus:ring-2 focus:ring-current">
                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        @endif
    </div>
</div>
