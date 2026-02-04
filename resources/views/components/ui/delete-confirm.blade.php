@props([
    'action',
    'message' => null,
    'buttonText' => null,
    'variant' => 'icon', // icon, button, text
])

@php
$defaultMessage = $message ?? __('Are you sure you want to delete this item? This action cannot be undone.');
$defaultButtonText = $buttonText ?? __('Delete');
@endphp

<div x-data="{ showModal: false }">
    @if($variant === 'icon')
        <button @click="showModal = true" type="button"
            class="p-2 rounded-lg hover:bg-accent-rose/10 text-zinc-500 dark:text-zinc-400 hover:text-accent-rose transition-colors"
            title="{{ $defaultButtonText }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    @elseif($variant === 'button')
        <button @click="showModal = true" type="button"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            {{ $defaultButtonText }}
        </button>
    @else
        <button @click="showModal = true" type="button"
            class="text-sm text-accent-rose hover:text-accent-rose/80 font-medium transition-colors">
            {{ $defaultButtonText }}
        </button>
    @endif

    <!-- Confirmation Modal -->
    <div x-show="showModal"
         x-cloak
         @click.away="showModal = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div @click.stop
                 x-show="showModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="relative w-full max-w-md bg-white dark:bg-surface-800 rounded-2xl shadow-xl p-6">

                <!-- Icon -->
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-accent-rose/10 rounded-full mb-4">
                    <svg class="w-6 h-6 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <!-- Content -->
                <h3 class="text-lg font-semibold text-center mb-2">{{ __('Confirm Deletion') }}</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 text-center mb-6">
                    {{ $defaultMessage }}
                </p>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button @click="showModal = false" type="button"
                        class="flex-1 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('Cancel') }}
                    </button>
                    <form action="{{ $action }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl bg-accent-rose text-white hover:bg-accent-rose/90 text-sm font-medium transition-all">
                            {{ $defaultButtonText }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
