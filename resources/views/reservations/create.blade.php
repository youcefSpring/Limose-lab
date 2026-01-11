<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('reservations.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Create New Reservation') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Reserve laboratory equipment for your research') }}</p>
            </div>
        </div>
    </header>

    <form method="POST" action="{{ route('reservations.store') }}" x-data="reservationForm()">
            @csrf

            <!-- Equipment & Quantity Section -->
            <div class="glass-card rounded-2xl p-6 mb-5">
                <h2 class="text-lg font-semibold mb-5">{{ __('Equipment Selection') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Material Selection -->
                    <div class="lg:col-span-2">
                        <label for="material_id" class="block text-sm font-medium mb-2">
                            {{ __('Material / Equipment') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="material_id" id="material_id" required x-model="materialId" @change="checkAvailability()"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('material_id') border-accent-rose @enderror">
                            <option value="">{{ __('Select a material') }}</option>
                            @foreach($materials ?? [] as $material)
                                <option value="{{ $material->id }}"
                                    data-quantity="{{ $material->quantity }}"
                                    data-name="{{ $material->name }}"
                                    {{ old('material_id', request('material')) == $material->id ? 'selected' : '' }}>
                                    {{ $material->name }} ({{ __('Available') }}: {{ $material->quantity }})
                                </option>
                            @endforeach
                        </select>
                        @error('material_id')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium mb-2">
                            {{ __('Quantity') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="number" name="quantity" id="quantity" required
                            min="1" :max="maxQuantity"
                            value="{{ old('quantity', 1) }}"
                            x-model="quantity" @change="checkAvailability()"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('quantity') border-accent-rose @enderror">
                        @error('quantity')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Selected Material Info -->
                <div x-show="materialId" x-cloak class="mt-4">
                    <div class="glass rounded-xl p-3 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-violet text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-accent-violet flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span><strong x-text="materialName"></strong> - {{ __('Available quantity') }}: <strong x-text="maxQuantity" class="font-mono"></strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservation Details Section -->
            <div class="glass-card rounded-2xl p-6 mb-5">
                <h2 class="text-lg font-semibold mb-5">{{ __('Reservation Details') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium mb-2">
                            {{ __('Start Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date" required
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('start_date') }}"
                            x-model="startDate" @change="checkAvailability()"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('start_date') border-accent-rose @enderror">
                        @error('start_date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium mb-2">
                            {{ __('End Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date" required
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('end_date') }}"
                            x-model="endDate" @change="checkAvailability()"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('end_date') border-accent-rose @enderror">
                        @error('end_date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration Display (Read-only visual) -->
                    <div x-show="duration > 0" x-cloak>
                        <label class="block text-sm font-medium mb-2">{{ __('Duration') }}</label>
                        <div class="py-2.5 px-4 bg-zinc-50 dark:bg-surface-700/30 border border-black/10 dark:border-white/10 rounded-xl text-sm font-mono" :class="duration > 30 ? 'text-accent-rose' : ''">
                            <span x-text="duration"></span> {{ __('days') }}
                            <span x-show="duration > 30" class="text-xs">({{ __('Max: 30') }})</span>
                        </div>
                    </div>

                    <!-- Purpose (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="purpose" class="block text-sm font-medium mb-2">
                            {{ __('Purpose of Reservation') }} <span class="text-accent-rose">*</span>
                        </label>
                        <textarea name="purpose" id="purpose" rows="3" required
                            placeholder="{{ __('Please describe the purpose of this reservation...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('purpose') border-accent-rose @enderror">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="notes" class="block text-sm font-medium mb-2">
                            {{ __('Additional Notes') }}
                        </label>
                        <textarea name="notes" id="notes" rows="2"
                            placeholder="{{ __('Any additional information...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('notes') border-accent-rose @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Availability Status -->
                <div x-show="checking || availabilityChecked" x-cloak class="mt-4">
                    <div x-show="checking" class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Checking availability...') }}
                    </div>

                    <div x-show="!checking && availabilityChecked" class="glass rounded-xl p-3 text-sm border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4" :class="available ? 'border-accent-emerald' : 'border-accent-rose'">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 flex-shrink-0" :class="available ? 'text-accent-emerald' : 'text-accent-rose'" fill="currentColor" viewBox="0 0 20 20">
                                <path x-show="available" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                <path x-show="!available" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span x-show="available">{{ __('Material is available for the selected dates and quantity') }}</span>
                            <span x-show="!available">{{ __('Material is not available. Please check conflicts or adjust your reservation.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Information (Compact Banner) -->
            <div class="glass rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-cyan/50 mb-5">
                <div class="flex items-start gap-3">
                    <svg class="h-4 w-4 text-accent-cyan flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-xs text-zinc-600 dark:text-zinc-300">
                        <strong class="font-semibold text-sm">{{ __('Important') }}:</strong>
                        {{ __('Maximum 3 active reservations per user') }} • {{ __('Maximum duration is 30 days') }} • {{ __('Approval required by material manager') }}
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('reservations.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" :disabled="!available || checking" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Submit Reservation') }}
                </button>
            </div>
        </form>

    @push('scripts')
    <script>
        function reservationForm() {
            return {
                materialId: '{{ old('material_id', request('material')) }}',
                materialName: '',
                maxQuantity: 0,
                startDate: '{{ old('start_date') }}',
                endDate: '{{ old('end_date') }}',
                quantity: {{ old('quantity', 1) }},
                checking: false,
                availabilityChecked: false,
                available: false,

                get duration() {
                    if (!this.startDate || !this.endDate) return 0;
                    const start = new Date(this.startDate);
                    const end = new Date(this.endDate);
                    const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                    return diff > 0 ? diff : 0;
                },

                init() {
                    this.$watch('materialId', value => {
                        const select = document.getElementById('material_id');
                        const option = select.options[select.selectedIndex];
                        if (option) {
                            this.maxQuantity = parseInt(option.dataset.quantity || 0);
                            this.materialName = option.dataset.name || '';
                        }
                    });

                    // Trigger initial setup if material is pre-selected
                    if (this.materialId) {
                        const select = document.getElementById('material_id');
                        const option = select.options[select.selectedIndex];
                        if (option) {
                            this.maxQuantity = parseInt(option.dataset.quantity || 0);
                            this.materialName = option.dataset.name || '';
                        }
                    }
                },

                checkAvailability() {
                    if (!this.materialId || !this.startDate || !this.endDate || !this.quantity) {
                        this.availabilityChecked = false;
                        return;
                    }

                    this.checking = true;
                    this.availabilityChecked = false;

                    fetch('{{ route('reservations.check-availability') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            material_id: this.materialId,
                            start_date: this.startDate,
                            end_date: this.endDate,
                            quantity: this.quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.checking = false;
                        this.availabilityChecked = true;
                        this.available = data.available || false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checking = false;
                        this.availabilityChecked = true;
                        this.available = false;
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
