<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('publications.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Add New Publication') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Add a research publication or paper') }}</p>
            </div>
        </div>
    </header>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('publications.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title Section (Multilingual) -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Title') }}</h2>

                <!-- Title (English) -->
                <div class="mb-5">
                    <label for="title" class="block text-sm font-medium mb-2">
                        {{ __('Title (English)') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('title') border-accent-rose @enderror"
                        placeholder="{{ __('Enter the publication title in English') }}">
                    @error('title')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title (French) -->
                <div class="mb-5">
                    <label for="title_fr" class="block text-sm font-medium mb-2">
                        {{ __('Title (French)') }}
                    </label>
                    <input type="text" name="title_fr" id="title_fr" value="{{ old('title_fr') }}"
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('title_fr') border-accent-rose @enderror"
                        placeholder="{{ __('Enter the publication title in French') }}">
                    @error('title_fr')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title (Arabic) -->
                <div>
                    <label for="title_ar" class="block text-sm font-medium mb-2">
                        {{ __('Title (Arabic)') }}
                    </label>
                    <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar') }}" dir="rtl"
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all text-right @error('title_ar') border-accent-rose @enderror"
                        placeholder="{{ __('Enter the publication title in Arabic') }}">
                    @error('title_ar')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Abstract Section (Multilingual) -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Abstract') }}</h2>

                <!-- Abstract (English) -->
                <div class="mb-5">
                    <label for="abstract" class="block text-sm font-medium mb-2">
                        {{ __('Abstract (English)') }} <span class="text-accent-rose">*</span>
                    </label>
                    <textarea name="abstract" id="abstract" rows="6" required
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none @error('abstract') border-accent-rose @enderror"
                        placeholder="{{ __('Enter the abstract in English') }}">{{ old('abstract') }}</textarea>
                    @error('abstract')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Abstract (French) -->
                <div class="mb-5">
                    <label for="abstract_fr" class="block text-sm font-medium mb-2">
                        {{ __('Abstract (French)') }}
                    </label>
                    <textarea name="abstract_fr" id="abstract_fr" rows="6"
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none @error('abstract_fr') border-accent-rose @enderror"
                        placeholder="{{ __('Enter the abstract in French') }}">{{ old('abstract_fr') }}</textarea>
                    @error('abstract_fr')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Abstract (Arabic) -->
                <div>
                    <label for="abstract_ar" class="block text-sm font-medium mb-2">
                        {{ __('Abstract (Arabic)') }}
                    </label>
                    <textarea name="abstract_ar" id="abstract_ar" rows="6" dir="rtl"
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none text-right @error('abstract_ar') border-accent-rose @enderror"
                        placeholder="{{ __('Enter the abstract in Arabic') }}">{{ old('abstract_ar') }}</textarea>
                    @error('abstract_ar')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Basic Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

                <!-- Authors -->
                <div class="mb-5">
                    <label for="authors" class="block text-sm font-medium mb-2">
                        {{ __('Authors') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="authors" id="authors" value="{{ old('authors') }}" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('authors') border-accent-rose @enderror"
                        placeholder="{{ __('e.g., John Doe, Jane Smith, Ahmed Ali') }}">
                    @error('authors')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Separate multiple authors with commas') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium mb-2">
                            {{ __('Type') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('type') border-accent-rose @enderror">
                            <option value="">{{ __('Select publication type') }}</option>
                            <option value="journal" {{ old('type') == 'journal' ? 'selected' : '' }}>{{ __('Journal') }}</option>
                            <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                            <option value="book" {{ old('type') == 'book' ? 'selected' : '' }}>{{ __('Book') }}</option>
                            <option value="chapter" {{ old('type') == 'chapter' ? 'selected' : '' }}>{{ __('Chapter') }}</option>
                            <option value="thesis" {{ old('type') == 'thesis' ? 'selected' : '' }}>{{ __('Thesis') }}</option>
                            <option value="preprint" {{ old('type') == 'preprint' ? 'selected' : '' }}>{{ __('Preprint') }}</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('status') border-accent-rose @enderror">
                            <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                            <option value="in_press" {{ old('status') == 'in_press' ? 'selected' : '' }}>{{ __('In Press') }}</option>
                            <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-sm font-medium mb-2">
                            {{ __('Year') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 5 }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all font-mono @error('year') border-accent-rose @enderror">
                        @error('year')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publication Date -->
                    <div>
                        <label for="publication_date" class="block text-sm font-medium mb-2">
                            {{ __('Publication Date') }}
                        </label>
                        <input type="date" name="publication_date" id="publication_date" value="{{ old('publication_date') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('publication_date') border-accent-rose @enderror">
                        @error('publication_date')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Publication Details Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Publication Details') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Journal -->
                    <div>
                        <label for="journal" class="block text-sm font-medium mb-2">
                            {{ __('Journal') }}
                        </label>
                        <input type="text" name="journal" id="journal" value="{{ old('journal') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('journal') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., Nature, Science') }}">
                        @error('journal')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Conference -->
                    <div>
                        <label for="conference" class="block text-sm font-medium mb-2">
                            {{ __('Conference') }}
                        </label>
                        <input type="text" name="conference" id="conference" value="{{ old('conference') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('conference') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., IEEE Conference 2024') }}">
                        @error('conference')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div>
                        <label for="publisher" class="block text-sm font-medium mb-2">
                            {{ __('Publisher') }}
                        </label>
                        <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('publisher') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., Springer, IEEE') }}">
                        @error('publisher')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Volume -->
                    <div>
                        <label for="volume" class="block text-sm font-medium mb-2">
                            {{ __('Volume') }}
                        </label>
                        <input type="text" name="volume" id="volume" value="{{ old('volume') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('volume') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 45') }}">
                        @error('volume')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Issue -->
                    <div>
                        <label for="issue" class="block text-sm font-medium mb-2">
                            {{ __('Issue') }}
                        </label>
                        <input type="text" name="issue" id="issue" value="{{ old('issue') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('issue') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 3') }}">
                        @error('issue')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pages -->
                    <div>
                        <label for="pages" class="block text-sm font-medium mb-2">
                            {{ __('Pages') }}
                        </label>
                        <input type="text" name="pages" id="pages" value="{{ old('pages') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all @error('pages') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 123-145') }}">
                        @error('pages')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Identifiers Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Identifiers & Links') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- DOI -->
                    <div>
                        <label for="doi" class="block text-sm font-medium mb-2">
                            {{ __('DOI') }}
                        </label>
                        <input type="text" name="doi" id="doi" value="{{ old('doi') }}"
                            class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all font-mono @error('doi') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 10.1234/example.2024') }}">
                        @error('doi')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-medium mb-2">
                            {{ __('ISBN') }}
                        </label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                            class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all font-mono @error('isbn') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 978-3-16-148410-0') }}">
                        @error('isbn')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div class="md:col-span-2">
                        <label for="url" class="block text-sm font-medium mb-2">
                            {{ __('URL') }}
                        </label>
                        <input type="url" name="url" id="url" value="{{ old('url') }}"
                            class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all font-mono @error('url') border-accent-rose @enderror"
                            placeholder="{{ __('https://example.com/publication') }}">
                        @error('url')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Research Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Research Information') }}</h2>

                <!-- Keywords -->
                <div class="mb-5">
                    <label for="keywords" class="block text-sm font-medium mb-2">
                        {{ __('Keywords') }}
                    </label>
                    <textarea name="keywords" id="keywords" rows="2"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none @error('keywords') border-accent-rose @enderror"
                        placeholder="{{ __('e.g., machine learning, artificial intelligence, deep learning') }}">{{ old('keywords') }}</textarea>
                    @error('keywords')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Separate keywords with commas') }}</p>
                </div>

                <!-- Research Areas -->
                <div>
                    <label for="research_areas" class="block text-sm font-medium mb-2">
                        {{ __('Research Areas') }}
                    </label>
                    <textarea name="research_areas" id="research_areas" rows="2"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none @error('research_areas') border-accent-rose @enderror"
                        placeholder="{{ __('e.g., Computer Science, Artificial Intelligence') }}">{{ old('research_areas') }}</textarea>
                    @error('research_areas')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Separate areas with commas') }}</p>
                </div>
            </div>

            <!-- Options Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Options') }}</h2>

                <!-- Open Access -->
                <div class="flex items-center gap-3 mb-4">
                    <input type="checkbox" name="is_open_access" id="is_open_access" value="1" {{ old('is_open_access') ? 'checked' : '' }}
                        class="w-4 h-4 text-accent-indigo bg-white dark:bg-surface-700/50 border-black/10 dark:border-white/10 rounded focus:ring-2 focus:ring-accent-indigo/50">
                    <label for="is_open_access" class="text-sm font-medium cursor-pointer">
                        {{ __('Open Access Publication') }}
                    </label>
                </div>

                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Check this if the publication is freely available to the public') }}</p>
            </div>

            <!-- PDF Upload Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Publication File') }}</h2>

                <div class="flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-black/10 dark:border-white/10 rounded-xl hover:border-accent-indigo/50 dark:hover:border-accent-indigo/50 transition-colors bg-white dark:bg-surface-700/30">
                    <div class="space-y-3 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-indigo/10 mb-2">
                            <svg class="w-8 h-8 text-accent-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex text-sm justify-center">
                            <label for="pdf_file" class="relative cursor-pointer rounded-md font-medium text-accent-indigo hover:text-accent-violet transition-colors px-2">
                                <span>{{ __('Upload PDF file') }}</span>
                                <input id="pdf_file" name="pdf_file" type="file" class="sr-only" accept="application/pdf">
                            </label>
                            <p class="text-zinc-500 dark:text-zinc-400">{{ __('or drag and drop') }}</p>
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('PDF up to 10MB') }}</p>
                    </div>
                </div>
                @error('pdf_file')
                    <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('publications.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-indigo to-accent-violet px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Create Publication') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
