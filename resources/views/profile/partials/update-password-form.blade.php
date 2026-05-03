<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('messages.Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('messages.Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium mb-2">{{ __('messages.Current Password') }}</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium mb-2">{{ __('messages.New Password') }}</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                autocomplete="new-password"
            >
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium mb-2">{{ __('messages.Confirm Password') }}</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-accent-amber to-accent-coral rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                {{ __('messages.Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-accent-emerald">
                    {{ __('messages.Saved!') }}
                </p>
            @endif
        </div>
    </form>
</section>