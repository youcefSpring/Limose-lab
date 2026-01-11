<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Add New User') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Create a new user account') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">
                            {{ __('Full Name') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all @error('name') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., John Doe') }}">
                        @error('name')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2 lg:col-span-2">
                        <label for="email" class="block text-sm font-medium mb-2">
                            {{ __('Email Address') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all @error('email') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., john@example.com') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-2">
                            {{ __('Phone Number') }}
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all @error('phone') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., +1 234 567 8900') }}">
                        @error('phone')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Research Group -->
                    <div>
                        <label for="research_group" class="block text-sm font-medium mb-2">
                            {{ __('Research Group') }}
                        </label>
                        <input type="text" name="research_group" id="research_group" value="{{ old('research_group') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all @error('research_group') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., Biotechnology Lab') }}">
                        @error('research_group')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all @error('status') border-accent-rose @enderror">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                            <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>{{ __('Banned') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Avatar -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-file-upload
                            name="avatar"
                            label="{{ __('Profile Picture') }}"
                            accept="image/*"
                            maxSize="2MB"
                            :currentFile="null"
                        />
                    </div>

                    <!-- Bio -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="bio" class="block text-sm font-medium mb-2">
                            {{ __('Bio') }}
                        </label>
                        <textarea name="bio" id="bio" rows="3"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all resize-none @error('bio') border-accent-rose @enderror"
                            placeholder="{{ __('Brief description about the user...') }}">{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Password') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">
                            {{ __('Password') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="password" name="password" id="password" required
                            class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all font-mono @error('password') border-accent-rose @enderror"
                            placeholder="{{ __('Min 8 characters') }}">
                        @error('password')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-2">
                            {{ __('Confirm Password') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all font-mono"
                            placeholder="{{ __('Re-enter password') }}">
                    </div>
                </div>
            </div>

            <!-- Roles -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Roles') }} <span class="text-accent-rose">*</span></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 p-4 glass-card rounded-xl cursor-pointer hover:bg-black/5 dark:hover:bg-white/5 transition-all">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}
                                class="w-4 h-4 text-accent-violet border-gray-300 rounded focus:ring-accent-violet">
                            <span class="text-sm font-medium">{{ __(ucfirst($role->name)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Create User') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
