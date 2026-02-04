<div x-data="{ open: false }" class="relative" @click.away="open = false">
    <!-- Language Switcher Button -->
    <button @click="open = !open"
            class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700"
            :aria-expanded="open"
            aria-haspopup="true">
        <!-- Current Language Flag/Icon -->
        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>

        <!-- Current Language Code -->
        <span class="font-medium text-gray-700 dark:text-gray-200 uppercase">
            {{ app()->getLocale() }}
        </span>

        <!-- Dropdown Icon -->
        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200"
             :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
         style="display: none;">

        <!-- Language Options -->
        <div class="py-1">
            <!-- English -->
            <a href="{{ route('locale.switch', 'en') }}"
               class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 {{ app()->getLocale() === 'en' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}">
                <span class="text-xl">🇬🇧</span>
                <span class="font-medium">English</span>
                @if(app()->getLocale() === 'en')
                    <svg class="w-4 h-4 ml-auto text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </a>

            <!-- French -->
            <a href="{{ route('locale.switch', 'fr') }}"
               class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 {{ app()->getLocale() === 'fr' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}">
                <span class="text-xl">🇫🇷</span>
                <span class="font-medium">Français</span>
                @if(app()->getLocale() === 'fr')
                    <svg class="w-4 h-4 ml-auto text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </a>

            <!-- Arabic -->
            <a href="{{ route('locale.switch', 'ar') }}"
               class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 {{ app()->getLocale() === 'ar' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}">
                <span class="text-xl">🇸🇦</span>
                <span class="font-medium">العربية</span>
                @if(app()->getLocale() === 'ar')
                    <svg class="w-4 h-4 ml-auto text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </a>
        </div>
    </div>
</div>
