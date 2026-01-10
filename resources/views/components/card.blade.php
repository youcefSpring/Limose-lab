@props(['title' => null, 'action' => null])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg']) }}>
    @if($title || $action)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            @if($title)
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $title }}
                </h3>
            @endif
            @if($action)
                <div>
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-6 text-gray-900 dark:text-gray-100">
        {{ $slot }}
    </div>
</div>
