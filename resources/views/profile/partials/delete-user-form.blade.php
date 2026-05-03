<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-accent-rose/10 text-accent-rose rounded-xl font-medium hover:bg-accent-rose/20 transition-colors"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div>
                <label for="password" class="block text-sm font-medium mb-2">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-accent-rose/50 focus:border-accent-rose transition-all"
                    placeholder="{{ __('Enter your password') }}"
                >
                @error('password', 'userDeletion')
                    <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-6 py-3 rounded-xl font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                >
                    {{ __('Cancel') }}
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 bg-accent-rose rounded-xl font-medium text-white hover:bg-accent-rose/90 transition-colors"
                >
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>