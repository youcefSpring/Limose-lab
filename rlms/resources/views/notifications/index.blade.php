<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Notifications') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('View all your notifications') }}</p>
        </div>
        @if(isset($unreadCount) && $unreadCount > 0)
            <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Mark All as Read') }}
                </button>
            </form>
        @endif
    </header>

    <!-- Filter Tabs -->
    <div class="glass-card rounded-2xl p-2 mb-6">
        <nav class="flex gap-2">
            <a href="{{ route('notifications.index') }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ !request('filter') ? 'bg-accent-cyan/10 text-accent-cyan' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('All') }}
            </a>
            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'unread' ? 'bg-accent-amber/10 text-accent-amber' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Unread') }}
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-amber/20 text-accent-amber">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
        </nav>
    </div>

    <!-- Notifications List -->
    @if(isset($notifications) && $notifications->count() > 0)
        <div class="space-y-3 mb-6">
            @foreach($notifications as $notification)
                <div class="glass-card rounded-2xl p-5 lg:p-6 {{ $notification->read_at ? '' : 'bg-accent-cyan/5' }} hover:scale-[1.01] transition-all duration-200">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                @php
                                    $iconColor = match($notification->type ?? 'info') {
                                        'success' => 'text-accent-emerald',
                                        'warning' => 'text-accent-amber',
                                        'error' => 'text-accent-rose',
                                        default => 'text-accent-cyan'
                                    };
                                    $bgColor = match($notification->type ?? 'info') {
                                        'success' => 'bg-accent-emerald/10',
                                        'warning' => 'bg-accent-amber/10',
                                        'error' => 'bg-accent-rose/10',
                                        default => 'bg-accent-cyan/10'
                                    };
                                @endphp
                                <div class="h-12 w-12 rounded-xl {{ $bgColor }} flex items-center justify-center">
                                    <svg class="h-6 w-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if(($notification->type ?? 'info') === 'success')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        @elseif(($notification->type ?? 'info') === 'warning')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        @elseif(($notification->type ?? 'info') === 'error')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        @endif
                                    </svg>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="text-sm font-semibold">
                                        {{ $notification->data['title'] ?? __('Notification') }}
                                    </p>
                                    @if(!$notification->read_at)
                                        <span class="w-2 h-2 rounded-full bg-accent-cyan flex-shrink-0"></span>
                                    @endif
                                </div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-2">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 font-mono">
                                    {{ $notification->created_at?->diffForHumans() }}
                                </p>

                                <!-- Action Link -->
                                @if(isset($notification->data['action_url']))
                                    <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center gap-1 text-sm text-accent-cyan hover:text-accent-cyan/80 font-medium mt-2">
                                        {{ $notification->data['action_text'] ?? __('View Details') }}
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 flex-shrink-0">
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-xl glass hover:glass-card transition-all" title="{{ __('Mark as read') }}">
                                        <svg class="h-5 w-5 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('notifications.destroy', $notification) }}"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this notification?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 transition-all" title="{{ __('Delete') }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $notifications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-cyan/10 mb-6">
                <svg class="w-10 h-10 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No notifications') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 max-w-md mx-auto">
                @if(request('filter') == 'unread')
                    {{ __('You have no unread notifications.') }}
                @else
                    {{ __('You\'re all caught up! No notifications to display.') }}
                @endif
            </p>
        </div>
    @endif
</x-app-layout>
