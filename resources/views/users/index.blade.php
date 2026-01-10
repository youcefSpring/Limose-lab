<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('User Management') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage system users and their roles') }}</p>
        </div>
        @can('create', App\Models\User::class)
            <a href="{{ route('users.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Add User') }}
            </a>
        @endcan
    </header>

    <!-- Filter Tabs -->
    <div class="glass-card rounded-2xl p-2 mb-6">
        <nav class="flex gap-2">
            <a href="{{ route('users.index') }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ !request('filter') ? 'bg-accent-violet/10 text-accent-violet' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('All Users') }}
                @if(isset($counts['all']))
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ !request('filter') ? 'bg-accent-violet/20 text-accent-violet' : 'bg-black/10 dark:bg-white/10' }}">
                        {{ $counts['all'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('users.index', ['filter' => 'pending']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'pending' ? 'bg-accent-amber/10 text-accent-amber' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Pending Approval') }}
                @if(isset($counts['pending']) && $counts['pending'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-amber/20 text-accent-amber">
                        {{ $counts['pending'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('users.index', ['filter' => 'active']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'active' ? 'bg-accent-emerald/10 text-accent-emerald' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Active') }}
            </a>
        </nav>
    </div>

    <!-- Users Grid -->
    @if(isset($users) && $users->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($users as $user)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.01] transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <!-- Avatar -->
                        <div class="h-20 w-20 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-white text-2xl font-bold mb-4 shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>

                        <!-- Name & Email -->
                        <h3 class="text-lg font-semibold mb-1">{{ $user->name }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3 truncate max-w-full">{{ $user->email }}</p>

                        <!-- Badges -->
                        <div class="flex flex-wrap items-center justify-center gap-2 mb-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                {{ ($user->role ?? 'user') === 'admin' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                {{ ($user->role ?? 'user') === 'researcher' ? 'bg-accent-violet/10 text-accent-violet' : '' }}
                                {{ ($user->role ?? 'user') === 'technician' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                {{ ($user->role ?? 'user') === 'phd_student' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                {{ ($user->role ?? 'user') === 'user' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                {{ __(ucfirst($user->role ?? 'user')) }}
                            </span>
                            @if($user->status)
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium
                                    {{ $user->status === 'active' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                    {{ $user->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                    {{ $user->status === 'suspended' ? 'bg-accent-rose/10 text-accent-rose' : '' }}">
                                    @if($user->status === 'active')
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    @endif
                                    {{ __(ucfirst($user->status)) }}
                                </span>
                            @endif
                        </div>

                        <!-- User Stats -->
                        @if(isset($user->stats))
                            <div class="grid grid-cols-3 gap-4 w-full py-4 border-t border-b border-black/5 dark:border-white/5 mb-4">
                                <div>
                                    <p class="text-xl font-bold font-mono text-accent-cyan">{{ $user->stats['reservations'] ?? 0 }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Reservations') }}</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold font-mono text-accent-rose">{{ $user->stats['projects'] ?? 0 }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Projects') }}</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold font-mono text-accent-emerald">{{ $user->stats['experiments'] ?? 0 }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Experiments') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2 w-full">
                            <a href="{{ route('users.show', $user) }}" class="flex-1 px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium text-center transition-all">
                                {{ __('View') }}
                            </a>
                            @can('update', $user)
                                <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 text-sm font-medium transition-all">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $users->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-violet/10 mb-6">
                <svg class="w-10 h-10 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No users found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                @if(request('filter'))
                    {{ __('No users match the selected filter.') }}
                @else
                    {{ __('Get started by adding your first user.') }}
                @endif
            </p>
        </div>
    @endif
</x-app-layout>
