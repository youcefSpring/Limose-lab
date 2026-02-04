@props([
    'step' => 1,
    'title' => null,
    'description' => null,
])

<div
    x-show="currentStep === {{ $step }}"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-4"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="space-y-6"
    style="display: none;"
>
    @if($title || $description)
        <div class="mb-6">
            @if($title)
                <h3 class="text-xl font-semibold mb-2">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
