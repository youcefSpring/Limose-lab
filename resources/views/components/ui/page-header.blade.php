@props([
    'title',
    'description' => null,
    'backUrl' => null,
])

<header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
    <div class="flex items-center gap-3">
        @if($backUrl)
            <a href="{{ $backUrl }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
        @endif
        <div class="flex-1">
            <h1 class="text-xl sm:text-2xl font-semibold">{{ $title }}</h1>
            @if($description)
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if(isset($actions))
        <div class="flex items-center gap-2 sm:gap-3">
            {{ $actions }}
        </div>
    @endif
</header>
