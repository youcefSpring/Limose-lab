@props(['action', 'title' => 'Confirm Deletion', 'message' => 'Are you sure you want to delete this item? This action cannot be undone.'])

<div x-data="{ open: false }" x-cloak>
    <!-- Trigger Button -->
    <button @click="open = true" type="button" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all']) }}>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        {{ $trigger ?? __('Delete') }}
    </button>

    <!-- Modal Overlay -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         @click="open = false">

        <!-- Modal Content -->
        <div @click.stop
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="glass-card rounded-2xl p-6 max-w-md w-full">

            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-accent-rose/10 mb-4">
                <svg class="h-6 w-6 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-semibold text-center mb-2">{{ $title }}</h3>

            <!-- Message -->
            <p class="text-sm text-zinc-600 dark:text-zinc-400 text-center mb-6">{{ $message }}</p>

            <!-- Actions -->
            <div class="flex gap-3">
                <button @click="open = false" type="button" class="flex-1 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </button>
                <form action="{{ $action }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-accent-rose text-white hover:opacity-90 text-sm font-medium transition-all">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    @endpush
@endonce
