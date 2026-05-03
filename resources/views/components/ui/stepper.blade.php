@props([
    'steps' => [], // Array of step labels
    'currentStep' => 1,
])

<div class="mb-8" x-data="{ currentStep: {{ $currentStep }} }">
    <!-- Step Indicators -->
    <div class="flex items-center justify-between mb-8">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
            @endphp

            <div class="flex items-center {{ $loop->last ? 'flex-1-0' : 'flex-1' }}">
                <!-- Step Circle -->
                <div class="flex flex-col items-center {{ $loop->last ? '' : 'w-full' }}">
                    <div class="flex items-center {{ $loop->last ? '' : 'w-full' }}">
                        <div
                            :class="{
                                'bg-gradient-to-r from-accent-indigo to-accent-violet text-white': currentStep >= {{ $stepNumber }},
                                'glass border-2 border-black/10 dark:border-white/10': currentStep < {{ $stepNumber }}
                            }"
                            class="relative z-10 flex items-center justify-center w-10 h-10 rounded-full font-semibold text-sm transition-all duration-300"
                        >
                            <!-- Checkmark for completed steps -->
                            <svg x-show="currentStep > {{ $stepNumber }}" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <!-- Number for current and future steps -->
                            <span x-show="currentStep <= {{ $stepNumber }}">{{ $stepNumber }}</span>
                        </div>

                        <!-- Connector Line -->
                        @if(!$loop->last)
                            <div
                                :class="{
                                    'bg-gradient-to-r from-accent-indigo to-accent-violet': currentStep > {{ $stepNumber }},
                                    'bg-black/10 dark:bg-white/10': currentStep <= {{ $stepNumber }}
                                }"
                                class="h-0.5 flex-1 mx-2 transition-all duration-300"
                            ></div>
                        @endif
                    </div>

                    <!-- Step Label -->
                    <div class="mt-3 text-center {{ $loop->last ? '' : 'w-full' }}">
                        <p
                            :class="{
                                'text-zinc-900 dark:text-white font-semibold': currentStep === {{ $stepNumber }},
                                'text-zinc-600 dark:text-zinc-400': currentStep !== {{ $stepNumber }}
                            }"
                            class="text-xs sm:text-sm transition-colors"
                        >
                            {{ $step }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Step Content -->
    <div>
        {{ $slot }}
    </div>

    <!-- Navigation Buttons (optional, to be included in form) -->
    <div class="mt-8 flex items-center justify-between">
        <button
            type="button"
            @click="if(currentStep > 1) currentStep--"
            x-show="currentStep > 1"
            x-transition
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
            </svg>
            {{ __('messages.Previous') }}
        </button>

        <div class="flex-1"></div>

        <button
            type="button"
            @click="if(currentStep < {{ count($steps) }}) currentStep++"
            x-show="currentStep < {{ count($steps) }}"
            x-transition
            class="flex items-center gap-2 bg-gradient-to-r from-accent-indigo to-accent-violet px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity"
        >
            {{ __('messages.Next') }}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"/>
            </svg>
        </button>

        <button
            type="submit"
            x-show="currentStep === {{ count($steps) }}"
            x-transition
            class="flex items-center gap-2 bg-gradient-to-r from-accent-indigo to-accent-violet px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ __('messages.Submit') }}
        </button>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('stepperForm', () => ({
        currentStep: 1,
        totalSteps: {{ count($steps) }},

        nextStep() {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.scrollToTop();
            }
        },

        previousStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
                this.scrollToTop();
            }
        },

        goToStep(step) {
            if (step >= 1 && step <= this.totalSteps) {
                this.currentStep = step;
                this.scrollToTop();
            }
        },

        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        isStepVisible(step) {
            return this.currentStep === step;
        }
    }));
});
</script>
