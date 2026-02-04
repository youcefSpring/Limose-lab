@props(['items' => []])

@if(count($items) > 0)
<nav class="flex items-center gap-2 text-sm mb-6" aria-label="{{ __('Breadcrumb') }}">
    <a href="{{ route('dashboard') }}" class="text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
    </a>

    @foreach($items as $index => $item)
        <svg class="w-4 h-4 text-zinc-400 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>

        @if(isset($item['url']) && $index < count($items) - 1)
            <a href="{{ $item['url'] }}" class="text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
                {{ $item['label'] }}
            </a>
        @else
            <span class="text-zinc-700 dark:text-zinc-200 font-medium">
                {{ $item['label'] }}
            </span>
        @endif
    @endforeach
</nav>
@endif
