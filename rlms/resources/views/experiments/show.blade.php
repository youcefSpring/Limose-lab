<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('experiments.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ $experiment->title ?? __('Experiment Details') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Experiment') }} #{{ $experiment->id ?? '---' }}</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium
            {{ $experiment->status === 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
            {{ $experiment->status === 'in_progress' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
            {{ $experiment->status === 'planned' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
            {{ $experiment->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
            <span class="w-2 h-2 rounded-full bg-current"></span>
            {{ __(ucfirst($experiment->status ?? 'pending')) }}
        </span>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Experiment Overview -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Experiment Overview') }}</h2>
                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Description') }}</h3>
                        <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $experiment->description }}</p>
                    </div>

                    @if($experiment->hypothesis)
                        <div>
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Hypothesis') }}</h3>
                            <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $experiment->hypothesis }}</p>
                        </div>
                    @endif

                    @if($experiment->procedure)
                        <div>
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Procedure') }}</h3>
                            <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $experiment->procedure }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Results -->
            @if($experiment->results)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Results') }}</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $experiment->results }}</p>
                    </div>
                </div>
            @endif

            <!-- Conclusions -->
            @if($experiment->conclusions)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Conclusions') }}</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $experiment->conclusions }}</p>
                    </div>
                </div>
            @endif

            <!-- Attached Files -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-semibold">{{ __('Attached Files') }} ({{ $experiment->files?->count() ?? 0 }})</h2>
                    @can('update', $experiment)
                        <button onclick="document.getElementById('file-upload-form').classList.toggle('hidden')"
                            class="text-sm text-accent-violet hover:text-accent-violet/80 font-medium">
                            {{ __('Upload File') }}
                        </button>
                    @endcan
                </div>

                <!-- Upload Form -->
                @can('update', $experiment)
                    <div id="file-upload-form" class="hidden mb-4 p-4 glass rounded-xl">
                        <form method="POST" action="{{ route('experiments.upload-file', $experiment) }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium mb-2">{{ __('Select File') }}</label>
                                <input type="file" name="file" required
                                    class="block w-full text-sm text-zinc-500 dark:text-zinc-400 file:{{ app()->getLocale() === 'ar' ? 'ml' : 'mr' }}-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent-violet/10 file:text-accent-violet hover:file:bg-accent-violet/20 cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">{{ __('Description') }}</label>
                                <input type="text" name="description" placeholder="{{ __('Optional file description') }}"
                                    class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2 px-3 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                            </div>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 text-sm font-medium transition-all">
                                {{ __('Upload') }}
                            </button>
                        </form>
                    </div>
                @endcan

                @if($experiment->files && $experiment->files->count() > 0)
                    <div class="space-y-2">
                        @foreach($experiment->files as $file)
                            <div class="flex items-center justify-between p-4 glass rounded-xl">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-lg bg-accent-cyan/10 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">{{ $file->filename }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $file->size ? number_format($file->size / 1024, 2) . ' KB' : '' }}
                                            • {{ __('Uploaded') }} {{ $file->created_at?->diffForHumans() }}
                                        </p>
                                        @if($file->description)
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">{{ $file->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    <a href="{{ route('experiments.download-file', [$experiment, $file]) }}" target="_blank"
                                        class="p-2 rounded-xl glass hover:glass-card transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                    @can('update', $experiment)
                                        <form method="POST" action="{{ route('experiments.delete-file', [$experiment, $file]) }}"
                                            onsubmit="return confirm('{{ __('Are you sure you want to delete this file?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 transition-all">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8">{{ __('No files attached yet') }}</p>
                @endif
            </div>

            <!-- Comments Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Comments') }} ({{ $experiment->comments?->count() ?? 0 }})</h2>

                <!-- Add Comment Form -->
                <form method="POST" action="{{ route('experiments.add-comment', $experiment) }}" class="mb-6">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-sm font-semibold text-white">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <textarea name="comment" rows="2" required
                                placeholder="{{ __('Add a comment...') }}"
                                class="w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none"></textarea>
                            <div class="mt-2">
                                <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-accent-amber to-accent-coral text-sm font-medium text-white hover:opacity-90 transition-opacity">
                                    {{ __('Post Comment') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Comments List -->
                @if($experiment->comments && $experiment->comments->count() > 0)
                    <div class="space-y-4 border-t border-black/5 dark:border-white/5 pt-5">
                        @foreach($experiment->comments as $comment)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-sm font-semibold text-white">
                                        {{ strtoupper(substr($comment->user?->name ?? 'U', 0, 2)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="glass rounded-xl p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-sm font-semibold">{{ $comment->user?->name }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at?->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8 border-t border-black/5 dark:border-white/5">
                        {{ __('No comments yet. Be the first to comment!') }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Experiment Info -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Experiment Information') }}</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Project') }}</dt>
                        <dd class="text-sm font-medium">
                            <a href="{{ route('projects.show', $experiment->project) }}" class="text-accent-violet hover:text-accent-violet/80">
                                {{ $experiment->project?->title }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Researcher') }}</dt>
                        <dd class="text-sm font-medium">{{ $experiment->researcher?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Date') }}</dt>
                        <dd class="text-sm font-medium font-mono">{{ $experiment->date?->format('M d, Y') }}</dd>
                    </div>
                    @if($experiment->duration)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Duration') }}</dt>
                            <dd class="text-sm font-medium">
                                <span class="font-mono">{{ $experiment->duration }}</span> {{ __('hours') }}
                            </dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Status') }}</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                {{ $experiment->status === 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                {{ $experiment->status === 'in_progress' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                {{ $experiment->status === 'planned' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ __(ucfirst($experiment->status)) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Created') }}</dt>
                        <dd class="text-sm font-medium font-mono">{{ $experiment->created_at?->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Materials Used -->
            @if($experiment->materials && $experiment->materials->count() > 0)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Materials Used') }}</h2>
                    <div class="space-y-2">
                        @foreach($experiment->materials as $material)
                            <div class="flex items-center justify-between p-3 glass rounded-xl">
                                <a href="{{ route('materials.show', $material) }}" class="text-sm text-accent-violet hover:text-accent-violet/80 truncate">
                                    {{ $material->name }}
                                </a>
                                @if($material->pivot->quantity)
                                    <span class="text-xs font-mono text-zinc-500 dark:text-zinc-400 flex-shrink-0">×{{ $material->pivot->quantity }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Actions -->
            @can('update', $experiment)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actions') }}</h2>
                    <div class="space-y-2">
                        <a href="{{ route('experiments.edit', $experiment) }}" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('Edit Experiment') }}
                        </a>
                        @can('delete', $experiment)
                            <form method="POST" action="{{ route('experiments.destroy', $experiment) }}"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this experiment?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 font-medium text-sm transition-all">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('Delete Experiment') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
