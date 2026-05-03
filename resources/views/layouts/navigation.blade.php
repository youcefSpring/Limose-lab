{{-- Navigation Functions Script --}}
<script>
    // Define navigation functions globally before sidebar renders
    if (!window.toggleNavGroup) {
        window.toggleNavGroup = function(group) {
            const element = document.getElementById('nav-' + group);
            const arrow = document.querySelector('.nav-arrow[data-group="' + group + '"]');

            if (element) {
                const isHidden = element.style.display === 'none';
                element.style.display = isHidden ? 'block' : 'none';

                if (arrow) {
                    arrow.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                }

                // Save state to localStorage
                try {
                    const navState = JSON.parse(localStorage.getItem('navState') || '{}');
                    navState[group] = isHidden;
                    localStorage.setItem('navState', JSON.stringify(navState));
                } catch(e) {
                    console.error('Error saving nav state:', e);
                }
            }
        };

        window.restoreNavState = function() {
            try {
                const navState = JSON.parse(localStorage.getItem('navState') || '{}');
                ['labManagement', 'research', 'administration', 'personal'].forEach(group => {
                    const element = document.getElementById('nav-' + group);
                    const arrow = document.querySelector('.nav-arrow[data-group="' + group + '"]');

                    if (element && navState[group] !== undefined) {
                        element.style.display = navState[group] ? 'block' : 'none';
                        if (arrow) {
                            arrow.style.transform = navState[group] ? 'rotate(180deg)' : 'rotate(0deg)';
                        }
                    }
                });
            } catch(e) {
                console.error('Error restoring nav state:', e);
            }
        };

        // Initialize on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', window.restoreNavState);
        } else {
            window.restoreNavState();
        }

        // Also restore on Turbo navigation
        document.addEventListener('turbo:load', window.restoreNavState);
    }
</script>

{{-- Nexus Sidebar Navigation --}}
<aside id="sidebar" 
         class="sidebar fixed top-0 h-screen w-64 glass border-r border-black/5 dark:border-white/5 flex flex-col z-40 transition-transform duration-300 ease-in-out {{ app()->getLocale() === 'ar' ? 'right-0 left-auto border-r-0 border-l' : 'left-0' }}"
         aria-label="{{ __('messages.Sidebar navigation') }}"
         role="navigation">
    {{-- Logo --}}
    <div class="p-6 border-b border-black/5 dark:border-white/5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-accent-amber to-accent-coral flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <span class="text-xl font-semibold tracking-tight">{{ config('app.name', 'RLMS') }}</span>
        </a>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto overflow-x-hidden" id="sidebar-nav">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-accent-amber' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="font-medium">{{ __('messages.Dashboard') }}</span>
        </a>

        {{-- Laboratory Management Group --}}
        <div class="space-y-1">
            <button onclick="toggleNavGroup('labManagement')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="font-medium">{{ __('messages.Laboratory Management') }}</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 nav-arrow" data-group="labManagement" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="nav-labManagement" class="{{ app()->getLocale() === 'ar' ? 'mr-4 border-r-2 pr-2' : 'ml-4 border-l-2 pl-2' }} border-black/5 dark:border-white/5 space-y-1" style="display: {{ request()->routeIs('materials.*', 'reservations.*', 'rooms.*', 'maintenance.*') ? 'block' : 'none' }}">
                <a href="{{ route('materials.index') }}" class="nav-item {{ request()->routeIs('materials.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('materials.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('materials.*') ? 'text-accent-violet' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Materials') }}</span>
                </a>
                <a href="{{ route('reservations.index') }}" class="nav-item {{ request()->routeIs('reservations.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('reservations.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('reservations.*') ? 'text-accent-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Reservations') }}</span>
                </a>
                <a href="{{ route('rooms.index') }}" class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('rooms.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('rooms.*') ? 'text-accent-teal' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Rooms') }}</span>
                </a>
                <a href="{{ route('maintenance.index') }}" class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('maintenance.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('maintenance.*') ? 'text-accent-coral' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Maintenance') }}</span>
                </a>
            </div>
        </div>

        {{-- Research Group --}}
        <div class="space-y-1">
            <button onclick="toggleNavGroup('research')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <span class="font-medium">{{ __('messages.Research') }}</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 nav-arrow" data-group="research" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="nav-research" class="{{ app()->getLocale() === 'ar' ? 'mr-4 border-r-2 pr-2' : 'ml-4 border-l-2 pl-2' }} border-black/5 dark:border-white/5 space-y-1" style="display: {{ request()->routeIs('projects.*', 'experiments.*', 'publications.*', 'events.*') ? 'block' : 'none' }}">
                <a href="{{ route('projects.index') }}" class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('projects.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('projects.*') ? 'text-accent-rose' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Projects') }}</span>
                </a>
                <a href="{{ route('experiments.index') }}" class="nav-item {{ request()->routeIs('experiments.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('experiments.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('experiments.*') ? 'text-accent-emerald' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Experiments') }}</span>
                </a>
                @canany(['publications.index'])
                <a href="{{ route('publications.index') }}" class="nav-item {{ request()->routeIs('publications.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('publications.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('publications.*') ? 'text-accent-indigo' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Publications') }}</span>
                </a>
                @endcanany
                <a href="{{ route('events.index') }}" class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('events.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('events.*') ? 'text-accent-amber' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Events') }}</span>
                </a>
            </div>
        </div>

        {{-- Administration Group (Admin Only) --}}
        @if(auth()->user()->hasRole('admin') || auth()->user()->can('viewAny', \App\Models\User::class) || auth()->user()->can('categories.manage'))
        <div class="space-y-1">
            <button onclick="toggleNavGroup('administration')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="font-medium">{{ __('messages.Administration') }}</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 nav-arrow" data-group="administration" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="nav-administration" class="{{ app()->getLocale() === 'ar' ? 'mr-4 border-r-2 pr-2' : 'ml-4 border-l-2 pl-2' }} border-black/5 dark:border-white/5 space-y-1" style="display: {{ request()->routeIs('users.*', 'material-categories.*', 'settings.*') ? 'block' : 'none' }}">
                @canany(['users.index'])
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('users.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('users.*') ? 'text-accent-violet' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Users') }}</span>
                </a>
                @endcanany
                @canany(['categories.manage'])
                <a href="{{ route('material-categories.index') }}" class="nav-item {{ request()->routeIs('material-categories.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('material-categories.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('material-categories.*') ? 'text-accent-cyan' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Categories') }}</span>
                </a>
                @endcanany
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('settings.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4 {{ request()->routeIs('settings.*') ? 'text-accent-rose' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.System Settings') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- Divider --}}
        <div class="pt-2 mt-2 border-t border-black/5 dark:border-white/5"></div>

        {{-- Personal Group --}}
        <div class="space-y-1">
            <button onclick="toggleNavGroup('personal')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5 transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-medium">{{ __('messages.Personal') }}</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="bg-accent-rose/20 text-accent-rose text-xs font-medium px-1.5 py-0.5 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 nav-arrow" data-group="personal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="nav-personal" class="{{ app()->getLocale() === 'ar' ? 'mr-4 border-r-2 pr-2' : 'ml-4 border-l-2 pl-2' }} border-black/5 dark:border-white/5 space-y-1" style="display: {{ request()->routeIs('notifications.*', 'profile.*') ? 'block' : 'none' }}">
                <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('notifications.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Notifications') }}</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="{{ app()->getLocale() === 'ar' ? 'mr-auto' : 'ml-auto' }} bg-accent-rose/20 text-accent-rose text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('profile.*') ? 'text-zinc-800 dark:text-white bg-black/5 dark:bg-white/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }} transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm">{{ __('messages.Settings') }}</span>
                </a>
            </div>
        </div>

    </nav>

    {{-- User Profile Section --}}
    <div class="mt-auto p-4 border-t border-black/5 dark:border-white/5">
        {{-- User Profile Card --}}
        <div class="glass rounded-xl p-3 flex items-center gap-3">
            <div class="relative flex-shrink-0">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full object-cover">
                @else
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-accent-violet to-accent-cyan flex items-center justify-center text-white font-semibold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <a href="{{ route('profile.edit') }}" class="text-xs font-medium truncate hover:text-accent-amber transition-colors block">{{ auth()->user()->name }}</a>
            </div>
        </div>
    </div>
</aside>

