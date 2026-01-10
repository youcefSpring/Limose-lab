<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('publications.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Publication Details') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ ucfirst($publication->type) }} • {{ $publication->year }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $publication)
                <a href="{{ route('publications.edit', $publication) }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit') }}
                </a>
            @endcan
            @can('delete', $publication)
                <form method="POST" action="{{ route('publications.destroy', $publication) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this publication?') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('Delete') }}
                    </button>
                </form>
            @endcan
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <!-- Title Card -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <div class="flex items-start gap-3 mb-4">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold mb-2">{{ $publication->title }}</h2>
                        @if($publication->title_fr || $publication->title_ar)
                            <div class="space-y-2 mt-4 pt-4 border-t border-black/10 dark:border-white/10">
                                @if($publication->title_fr)
                                    <div>
                                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ __('French') }}</span>
                                        <p class="text-lg font-semibold mt-1">{{ $publication->title_fr }}</p>
                                    </div>
                                @endif
                                @if($publication->title_ar)
                                    <div>
                                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ __('Arabic') }}</span>
                                        <p class="text-lg font-semibold mt-1 text-right" dir="rtl">{{ $publication->title_ar }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <!-- Type Badge -->
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-violet/10 text-accent-violet">
                            {{ ucfirst($publication->type) }}
                        </span>
                        @if($publication->is_featured)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-rose/10 text-accent-rose">
                                ⭐ {{ __('Featured') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                    <span>👤 {{ $publication->authors }}</span>
                    <span>📅 {{ $publication->year }}</span>
                    @if($publication->is_open_access)
                        <span class="text-accent-emerald">🔓 {{ __('Open Access') }}</span>
                    @endif
                </div>
            </div>

            <!-- Abstract -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Abstract') }}</h3>
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $publication->abstract }}</p>

                    @if($publication->abstract_fr || $publication->abstract_ar)
                        <div class="space-y-4 mt-6 pt-6 border-t border-black/10 dark:border-white/10">
                            @if($publication->abstract_fr)
                                <div>
                                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-2 block">{{ __('French') }}</span>
                                    <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $publication->abstract_fr }}</p>
                                </div>
                            @endif
                            @if($publication->abstract_ar)
                                <div>
                                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-2 block">{{ __('Arabic') }}</span>
                                    <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line leading-relaxed text-right" dir="rtl">{{ $publication->abstract_ar }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Publication Details -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h3 class="text-lg font-semibold mb-5">{{ __('Publication Details') }}</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($publication->journal)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Journal') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->journal }}</dd>
                        </div>
                    @endif

                    @if($publication->conference)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Conference') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->conference }}</dd>
                        </div>
                    @endif

                    @if($publication->publisher)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Publisher') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->publisher }}</dd>
                        </div>
                    @endif

                    @if($publication->volume)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Volume') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->volume }}</dd>
                        </div>
                    @endif

                    @if($publication->issue)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Issue') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->issue }}</dd>
                        </div>
                    @endif

                    @if($publication->pages)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Pages') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->pages }}</dd>
                        </div>
                    @endif

                    @if($publication->publication_date)
                        <div class="glass-card rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Publication Date') }}</dt>
                            <dd class="text-base font-semibold">{{ $publication->publication_date->format('d M Y') }}</dd>
                        </div>
                    @endif

                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Status') }}</dt>
                        <dd class="text-base font-semibold">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                {{ $publication->status === 'published' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                {{ $publication->status === 'in_press' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                {{ $publication->status === 'submitted' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                {{ $publication->status === 'draft' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ __(ucfirst(str_replace('_', ' ', $publication->status))) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Identifiers & Links -->
            @if($publication->doi || $publication->isbn || $publication->url)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h3 class="text-lg font-semibold mb-5">{{ __('Identifiers & Links') }}</h3>
                    <div class="space-y-3">
                        @if($publication->doi)
                            <div class="flex items-center justify-between p-4 glass-card rounded-xl">
                                <div>
                                    <dt class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('DOI') }}</dt>
                                    <dd class="text-base font-mono font-medium mt-1">{{ $publication->doi }}</dd>
                                </div>
                                <a href="https://doi.org/{{ $publication->doi }}" target="_blank" rel="noopener" class="text-sm text-accent-indigo hover:text-accent-violet transition-colors">
                                    {{ __('View') }} →
                                </a>
                            </div>
                        @endif

                        @if($publication->isbn)
                            <div class="flex items-center justify-between p-4 glass-card rounded-xl">
                                <div>
                                    <dt class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('ISBN') }}</dt>
                                    <dd class="text-base font-mono font-medium mt-1">{{ $publication->isbn }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($publication->url)
                            <div class="flex items-center justify-between p-4 glass-card rounded-xl">
                                <div class="flex-1 mr-4">
                                    <dt class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('URL') }}</dt>
                                    <dd class="text-base font-mono text-sm mt-1 truncate">{{ $publication->url }}</dd>
                                </div>
                                <a href="{{ $publication->url }}" target="_blank" rel="noopener" class="text-sm text-accent-indigo hover:text-accent-violet transition-colors whitespace-nowrap">
                                    {{ __('Visit') }} →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Keywords & Research Areas -->
            @if($publication->keywords || $publication->research_areas)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h3 class="text-lg font-semibold mb-5">{{ __('Research Information') }}</h3>

                    @if($publication->keywords)
                        <div class="mb-5">
                            <h4 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-3">{{ __('Keywords') }}</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $publication->keywords) as $keyword)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm bg-accent-indigo/10 text-accent-indigo">
                                        {{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($publication->research_areas)
                        <div>
                            <h4 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-3">{{ __('Research Areas') }}</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $publication->research_areas) as $area)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm bg-accent-violet/10 text-accent-violet">
                                        {{ trim($area) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- PDF File -->
            @if($publication->pdf_file)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Publication File') }}</h3>
                    <div class="flex items-center justify-between p-5 bg-gradient-to-r from-accent-indigo/10 to-accent-violet/10 rounded-xl border border-accent-indigo/20">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-accent-indigo/20">
                                <svg class="w-6 h-6 text-accent-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-zinc-800 dark:text-white">{{ __('PDF Document') }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ basename($publication->pdf_file) }}</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($publication->pdf_file) }}" target="_blank" class="flex items-center gap-2 bg-accent-indigo px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ __('Download') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-4 lg:space-y-6">
            <!-- Visibility Status -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Visibility') }}</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Current Status') }}</span>
                        <div class="mt-2">
                            @if($publication->visibility === 'public')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium bg-accent-emerald/10 text-accent-emerald">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    {{ __('Public') }}
                                </span>
                            @elseif($publication->visibility === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium bg-accent-amber/10 text-accent-amber">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    {{ __('Pending Approval') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium bg-zinc-500/10 text-zinc-500">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    {{ __('Private') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @can('approve', App\Models\Publication::class)
                        @if($publication->visibility === 'pending')
                            <div class="pt-4 border-t border-black/10 dark:border-white/10 space-y-2">
                                <form method="POST" action="{{ route('publications.approve', $publication) }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-accent-emerald px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ __('Approve') }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('publications.reject', $publication) }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-accent-rose px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        {{ __('Reject') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endcan
                </div>
            </div>

            <!-- Author Information -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Submitted By') }}</h3>
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-accent-indigo to-accent-violet flex items-center justify-center">
                        <span class="text-base font-semibold text-white">
                            {{ substr($publication->user->name ?? 'U', 0, 2) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium">{{ $publication->user->name ?? __('Unknown User') }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $publication->user->email ?? '' }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-black/10 dark:border-white/10 text-sm text-zinc-500 dark:text-zinc-400">
                    <div class="flex justify-between">
                        <span>{{ __('Created') }}</span>
                        <span class="font-medium">{{ $publication->created_at?->format('d M Y') }}</span>
                    </div>
                    @if($publication->updated_at != $publication->created_at)
                        <div class="flex justify-between mt-2">
                            <span>{{ __('Updated') }}</span>
                            <span class="font-medium">{{ $publication->updated_at?->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Citations -->
            @if($publication->citations_count && $publication->citations_count > 0)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Citations') }}</h3>
                    <div class="text-center py-4">
                        <div class="text-4xl font-bold bg-gradient-to-r from-accent-indigo to-accent-violet bg-clip-text text-transparent">
                            {{ $publication->citations_count }}
                        </div>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">{{ __('Total Citations') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
