<x-app-layout>
    <!-- Breadcrumbs -->
    <x-breadcrumbs :items="[
        ['label' => __('Publications'), 'url' => route('publications.index')],
        ['label' => __('Create Publication')]
    ]" />

    <!-- Page Header -->
    <x-ui.page-header
        :title="__('Add New Publication')"
        :description="__('Add a research publication or paper using our step-by-step wizard')"
        :backUrl="route('publications.index')"
    />

    <form method="POST" action="{{ route('publications.store') }}" enctype="multipart/form-data" x-data="{ currentStep: 1 }">
        @csrf

        <!-- Stepper -->
        <x-ui.stepper :steps="[
            __('Basic Information'),
            __('Publication Details'),
            __('Identifiers'),
            __('Research Info'),
            __('Files & Review')
        ]">
            <!-- Step 1: Basic Information -->
            <x-ui.step :step="1">
                <x-ui.card>
                    <div class="space-y-6">
                        <!-- Title (Multilingual with Tabs) -->
                        <x-ui.multilingual-input
                            label="{{ __('Title') }}"
                            name="title"
                            :required="true"
                            :errors="[
                                'en' => $errors->first('title'),
                                'fr' => $errors->first('title_fr'),
                                'ar' => $errors->first('title_ar')
                            ]"
                        />

                        <!-- Abstract (Multilingual with Tabs) -->
                        <x-ui.multilingual-input
                            label="{{ __('Abstract') }}"
                            name="abstract"
                            type="textarea"
                            :rows="6"
                            :required="true"
                            :errors="[
                                'en' => $errors->first('abstract'),
                                'fr' => $errors->first('abstract_fr'),
                                'ar' => $errors->first('abstract_ar')
                            ]"
                        />

                        <!-- Authors -->
                        <x-ui.input
                            label="{{ __('Authors') }}"
                            name="authors"
                            :required="true"
                            :error="$errors->first('authors')"
                            hint="{{ __('Separate multiple authors with commas') }}"
                            placeholder="John Doe, Jane Smith, Ahmed Ali"
                        />

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- Type -->
                            <x-ui.select
                                label="{{ __('Type') }}"
                                name="type"
                                :required="true"
                                :error="$errors->first('type')"
                                placeholder="{{ __('Select publication type') }}"
                            >
                                <option value="journal" {{ old('type') == 'journal' ? 'selected' : '' }}>{{ __('Journal') }}</option>
                                <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                                <option value="book" {{ old('type') == 'book' ? 'selected' : '' }}>{{ __('Book') }}</option>
                                <option value="chapter" {{ old('type') == 'chapter' ? 'selected' : '' }}>{{ __('Chapter') }}</option>
                                <option value="thesis" {{ old('type') == 'thesis' ? 'selected' : '' }}>{{ __('Thesis') }}</option>
                                <option value="preprint" {{ old('type') == 'preprint' ? 'selected' : '' }}>{{ __('Preprint') }}</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </x-ui.select>

                            <!-- Status -->
                            <x-ui.select
                                label="{{ __('Status') }}"
                                name="status"
                                :required="true"
                                :error="$errors->first('status')"
                            >
                                <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                <option value="in_press" {{ old('status') == 'in_press' ? 'selected' : '' }}>{{ __('In Press') }}</option>
                                <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                            </x-ui.select>

                            <!-- Year -->
                            <x-ui.input
                                label="{{ __('Year') }}"
                                name="year"
                                type="number"
                                :required="true"
                                :error="$errors->first('year')"
                                :value="old('year', date('Y'))"
                                min="1900"
                                :max="date('Y') + 5"
                            />
                        </div>

                        <!-- Publication Date -->
                        <x-ui.input
                            label="{{ __('Publication Date') }}"
                            name="publication_date"
                            type="date"
                            :error="$errors->first('publication_date')"
                        />
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 2: Publication Details -->
            <x-ui.step :step="2">
                <x-ui.card>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Publisher -->
                            <x-ui.input
                                label="{{ __('Publisher') }}"
                                name="publisher"
                                :error="$errors->first('publisher')"
                                placeholder="Springer, IEEE"
                            />

                            <!-- Volume -->
                            <x-ui.input
                                label="{{ __('Volume') }}"
                                name="volume"
                                :error="$errors->first('volume')"
                                placeholder="45"
                            />

                            <!-- Issue -->
                            <x-ui.input
                                label="{{ __('Issue') }}"
                                name="issue"
                                :error="$errors->first('issue')"
                                placeholder="3"
                            />

                            <!-- Pages -->
                            <x-ui.input
                                label="{{ __('Pages') }}"
                                name="pages"
                                :error="$errors->first('pages')"
                                placeholder="123-145"
                            />
                        </div>

                        <!-- Journal -->
                        <x-ui.input
                            label="{{ __('Journal') }}"
                            name="journal"
                            :error="$errors->first('journal')"
                            placeholder="Nature, Science"
                            hint="{{ __('For journal articles only') }}"
                        />

                        <!-- Conference -->
                        <x-ui.input
                            label="{{ __('Conference') }}"
                            name="conference"
                            :error="$errors->first('conference')"
                            placeholder="IEEE Conference 2024"
                            hint="{{ __('For conference papers only') }}"
                        />
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 3: Identifiers & Links -->
            <x-ui.step :step="3">
                <x-ui.card>
                    <div class="space-y-6">
                        <!-- DOI -->
                        <x-ui.input
                            label="{{ __('DOI') }}"
                            name="doi"
                            :error="$errors->first('doi')"
                            placeholder="10.1234/example.2024"
                            hint="{{ __('Digital Object Identifier') }}"
                        />

                        <!-- ISBN -->
                        <x-ui.input
                            label="{{ __('ISBN') }}"
                            name="isbn"
                            :error="$errors->first('isbn')"
                            placeholder="978-3-16-148410-0"
                            hint="{{ __('For books and book chapters') }}"
                        />

                        <!-- URL -->
                        <x-ui.input
                            label="{{ __('URL') }}"
                            name="url"
                            type="url"
                            :error="$errors->first('url')"
                            placeholder="https://example.com/publication"
                            hint="{{ __('Link to the online version') }}"
                        />
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 4: Research Information -->
            <x-ui.step :step="4">
                <x-ui.card>
                    <div class="space-y-6">
                        <!-- Keywords -->
                        <div class="space-y-2">
                            <label for="keywords" class="block text-sm font-medium">
                                {{ __('Keywords') }}
                            </label>
                            <textarea name="keywords" id="keywords" rows="3"
                                class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $errors->has('keywords') ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none"
                                placeholder="machine learning, artificial intelligence, deep learning">{{ old('keywords') }}</textarea>
                            @error('keywords')
                                <p class="text-xs text-accent-rose">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('Separate keywords with commas') }}</p>
                        </div>

                        <!-- Research Areas -->
                        <div class="space-y-2">
                            <label for="research_areas" class="block text-sm font-medium">
                                {{ __('Research Areas') }}
                            </label>
                            <textarea name="research_areas" id="research_areas" rows="3"
                                class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $errors->has('research_areas') ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none"
                                placeholder="Computer Science, Artificial Intelligence">{{ old('research_areas') }}</textarea>
                            @error('research_areas')
                                <p class="text-xs text-accent-rose">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('Separate areas with commas') }}</p>
                        </div>

                        <!-- Citations Count -->
                        <x-ui.input
                            label="{{ __('Citations Count') }}"
                            name="citations_count"
                            type="number"
                            :error="$errors->first('citations_count')"
                            min="0"
                            placeholder="0"
                            hint="{{ __('Number of times this publication has been cited') }}"
                        />
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 5: Files & Review -->
            <x-ui.step :step="5">
                <div class="space-y-6">
                    <!-- Options -->
                    <x-ui.card>
                        <h3 class="text-lg font-semibold mb-4">{{ __('Options') }}</h3>

                        <div class="space-y-4">
                            <!-- Open Access -->
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_open_access" id="is_open_access" value="1" {{ old('is_open_access') ? 'checked' : '' }}
                                    class="w-4 h-4 text-accent-indigo bg-white dark:bg-surface-700/50 border-black/10 dark:border-white/10 rounded focus:ring-2 focus:ring-accent-indigo/50">
                                <label for="is_open_access" class="text-sm font-medium cursor-pointer">
                                    {{ __('Open Access Publication') }}
                                </label>
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 ml-7">
                                {{ __('Check this if the publication is freely available to the public') }}
                            </p>
                        </div>
                    </x-ui.card>

                    <!-- PDF Upload -->
                    <x-ui.card>
                        <h3 class="text-lg font-semibold mb-4">{{ __('Publication File') }}</h3>

                        <x-file-upload
                            name="pdf_file"
                            label="{{ __('PDF File') }}"
                            accept=".pdf,.doc,.docx,.odt"
                            maxSize="10MB"
                        />
                    </x-ui.card>

                    <!-- Review Summary -->
                    <x-ui.card padding="lg">
                        <div class="text-center py-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-accent-indigo to-accent-violet mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">{{ __('Ready to Submit') }}</h3>
                            <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                                {{ __('Review your information and click submit to create your publication.') }}
                            </p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-500">
                                @if(!auth()->user()->hasRole('admin'))
                                    {{ __('Your publication will be sent for review before being published.') }}
                                @else
                                    {{ __('Your publication will be published immediately.') }}
                                @endif
                            </p>
                        </div>
                    </x-ui.card>
                </div>
            </x-ui.step>
        </x-ui.stepper>
    </form>
</x-app-layout>
