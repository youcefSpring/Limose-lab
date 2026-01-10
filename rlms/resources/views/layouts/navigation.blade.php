{{-- Nexus Sidebar Navigation --}}
<aside id="sidebar" class="sidebar fixed {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} top-0 h-screen w-64 glass border-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }} border-black/5 dark:border-white/5 flex flex-col z-50 -translate-x-full lg:translate-x-0">
    {{-- Logo & Close Button --}}
    <div class="p-6 border-b border-black/5 dark:border-white/5">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-accent-amber to-accent-coral flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <span class="text-xl font-semibold tracking-tight">{{ config('app.name', 'RLMS') }}</span>
            </a>
            <button class="p-2 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 lg:hidden" onclick="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-accent-amber' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="font-medium">{{ __('Dashboard') }}</span>
        </a>

        {{-- Materials --}}
        <a href="{{ route('materials.index') }}" class="nav-item {{ request()->routeIs('materials.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('materials.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('materials.*') ? 'text-accent-violet' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span>{{ __('Materials') }}</span>
        </a>

        {{-- Reservations --}}
        <a href="{{ route('reservations.index') }}" class="nav-item {{ request()->routeIs('reservations.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('reservations.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('reservations.*') ? 'text-accent-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ __('Reservations') }}</span>
        </a>

        {{-- Projects --}}
        <a href="{{ route('projects.index') }}" class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('projects.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('projects.*') ? 'text-accent-rose' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            <span>{{ __('Projects') }}</span>
        </a>

        {{-- Experiments --}}
        <a href="{{ route('experiments.index') }}" class="nav-item {{ request()->routeIs('experiments.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('experiments.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('experiments.*') ? 'text-accent-emerald' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
            <span>{{ __('Experiments') }}</span>
        </a>

        {{-- Events --}}
        <a href="{{ route('events.index') }}" class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('events.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('events.*') ? 'text-accent-amber' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>{{ __('Events') }}</span>
        </a>

        {{-- Maintenance --}}
        <a href="{{ route('maintenance.index') }}" class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('maintenance.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('maintenance.*') ? 'text-accent-coral' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>{{ __('Maintenance') }}</span>
        </a>

        @canany(['publications.index'])
        {{-- Publications --}}
        <a href="{{ route('publications.index') }}" class="nav-item {{ request()->routeIs('publications.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('publications.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('publications.*') ? 'text-accent-indigo' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>{{ __('Publications') }}</span>
        </a>
        @endcanany

        @can('manage-users')
        {{-- Users --}}
        <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('users.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('users.*') ? 'text-accent-violet' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span>{{ __('Users') }}</span>
        </a>
        @endcan

        @canany(['categories.manage'])
        {{-- Material Categories --}}
        <a href="{{ route('material-categories.index') }}" class="nav-item {{ request()->routeIs('material-categories.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('material-categories.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('material-categories.*') ? 'text-accent-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <span>{{ __('Categories') }}</span>
        </a>
        @endcanany

        @if(auth()->user()->hasRole('admin'))
        {{-- Settings (Admin only) --}}
        <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('settings.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('settings.*') ? 'text-accent-rose' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            <span>{{ __('System Settings') }}</span>
        </a>
        @endif

        {{-- Divider --}}
        <div class="pt-4 mt-4 border-t border-black/5 dark:border-white/5">
            {{-- Notifications --}}
            <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('notifications.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span>{{ __('Notifications') }}</span>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="ml-auto bg-accent-rose/20 text-accent-rose text-xs font-medium px-2 py-0.5 rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>

            {{-- Profile --}}
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('profile.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ __('Settings') }}</span>
            </a>
        </div>
    </nav>

    {{-- User Profile Section --}}
    <div class="p-4 border-t border-black/5 dark:border-white/5">
        <div class="glass-card rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="relative">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-cyan flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-0.5 {{ app()->getLocale() === 'ar' ? '-left-0.5' : '-right-0.5' }} w-3 h-3 bg-accent-emerald rounded-full border-2 border-white dark:border-surface-800"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-zinc-500 dark:text-zinc-400 hover:text-accent-rose transition-colors" title="{{ __('Logout') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

{{-- Top Header Bar --}}
<div class="lg:hidden fixed top-0 left-0 right-0 z-30 glass border-b border-black/5 dark:border-white/5">
    <div class="flex items-center justify-between p-4">
        <button id="hamburger" class="hamburger p-2 rounded-xl bg-white dark:bg-surface-700/50 border border-black/5 dark:border-white/5 hover:bg-zinc-100 dark:hover:bg-surface-600/50 transition-colors" onclick="toggleSidebar()">
            <div class="w-5 h-5 flex flex-col justify-center gap-1.5">
                <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
            </div>
        </button>

        <span class="text-lg font-semibold">{{ config('app.name', 'RLMS') }}</span>

        <button onclick="toggleTheme()" class="relative p-2.5 rounded-xl bg-white dark:bg-surface-700/50 border border-black/5 dark:border-white/5 hover:bg-zinc-100 dark:hover:bg-surface-600/50 transition-all">
            <div class="relative w-5 h-5">
                <svg class="w-5 h-5 text-accent-amber absolute inset-0 transition-all duration-500 dark:opacity-0 dark:rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg class="w-5 h-5 text-accent-violet absolute inset-0 transition-all duration-500 opacity-0 -rotate-90 scale-0 dark:opacity-100 dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </div>
        </button>
    </div>
</div>

{{-- Spacer for mobile header --}}
<div class="h-16 lg:hidden"></div>
