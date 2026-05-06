<x-app-layout>
    @php
        $unreadCount = $messages->filter(fn($m) => !$m->is_read)->count();
    @endphp
    
    <header class="mb-6 lg:mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Contact Messages') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">
                    {{ __('messages.All') }}: {{ $messages->total() }} | 
                    {{ __('messages.Unread') }}: {{ $unreadCount }}
                </p>
            </div>
        </div>
    </header>

    <x-primary-button onclick="location.href='{{ route('dashboard') }}'" class="mb-4">
        {{ __('messages.Back to Dashboard') }}
    </x-primary-button>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-card rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        {{ __('messages.Name') }}
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        {{ __('messages.Subject') }}
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        {{ __('messages.Date') }}
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        {{ __('messages.Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5 dark:divide-white/5">
                @forelse($messages as $message)
                    <tr class="{{ !$message->is_read ? 'bg-amber-500/5' : '' }}">
                        <td class="px-4 py-3">
                            <div class="font-medium {{ !$message->is_read ? 'text-amber-700 dark:text-amber-400' : '' }}">
                                {{ $message->name }}
                            </div>
                            <div class="text-sm text-zinc-500">{{ $message->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            {{ $message->subject }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500">
                            {{ $message->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" 
                                    onclick="window.dispatchEvent(new CustomEvent('open-view-modal', { detail: { 
                                        name: '{{ $message->name }}', 
                                        email: '{{ $message->email }}', 
                                        subject: '{{ $message->subject }}', 
                                        message: '{{ nl2br(e($message->message)) }}', 
                                        date: '{{ $message->created_at->format('Y-m-d H:i:s') }}',
                                        isRead: {{ $message->is_read ? 'true' : 'false' }}
                                    } }))"
                                    class="text-amber-600 hover:text-amber-700 text-sm font-medium mr-3">
                                {{ __('messages.View') }}
                            </button>
                            <button type="button"
                                    onclick="window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { 
                                        id: {{ $message->id }},
                                        name: '{{ $message->name }}',
                                        subject: '{{ $message->subject }}'
                                    } }))"
                                    class="text-red-600 hover:text-red-700 text-sm font-medium">
                                {{ __('messages.Delete') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-zinc-500">
                            {{ __('messages.No Data Available') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    @endif

    <!-- View Message Modal -->
    <div x-data="{ open: false, name: '', email: '', subject: '', message: '', date: '', isRead: false }"
         @open-view-modal.window="open = true; name = $event.detail.name; email = $event.detail.email; subject = $event.detail.subject; message = $event.detail.message; date = $event.detail.date; isRead = $event.detail.isRead"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center px-4">
                <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
                <div class="relative bg-white dark:bg-zinc-800 rounded-2xl shadow-xl w-full max-w-lg p-6 z-10"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-xl font-semibold mb-4">{{ __('messages.Contact Messages') }}</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('messages.Name') }}</label>
                            <p class="font-medium" x-text="name"></p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('messages.Email') }}</label>
                            <p class="font-medium text-amber-600">
                                <a :href="'mailto:' + email" x-text="email"></a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('messages.Date') }}</label>
                            <p class="font-medium" x-text="date"></p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('messages.Subject') }}</label>
                            <p class="font-medium" x-text="subject"></p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('messages.Message') }}</label>
                            <div class="p-3 mt-1 rounded-lg bg-zinc-50 dark:bg-zinc-700/50 border border-black/5 dark:border-white/5 whitespace-pre-wrap" x-text="message"></div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="open = false">
                            {{ __('messages.Close') }}
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: false, id: null, name: '', subject: '' }"
         @open-delete-modal.window="open = true; id = $event.detail.id; name = $event.detail.name; subject = $event.detail.subject"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center px-4">
                <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
                <div class="relative bg-white dark:bg-zinc-800 rounded-2xl shadow-xl w-full max-w-md p-6 z-10"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <h2 class="text-lg font-semibold text-center mb-2">{{ __('messages.Delete Message') }}</h2>
                    <p class="text-zinc-500 dark:text-zinc-400 text-center mb-6">
                        {{ __('messages.Confirm Delete') }}
                    </p>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-lg p-3 mb-6">
                        <p class="text-sm"><span class="font-medium">From:</span> <span x-text="name"></span></p>
                        <p class="text-sm"><span class="font-medium">Subject:</span> <span x-text="subject"></span></p>
                    </div>

                    <div class="flex gap-3">
                        <x-secondary-button @click="open = false" class="flex-1">
                            {{ __('messages.Cancel') }}
                        </x-secondary-button>
                        <form :action="`/contact-messages/${id}`" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" class="w-full">
                                {{ __('messages.Delete') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>