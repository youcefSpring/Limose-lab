<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('messages.Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium mb-2">{{ __('messages.Name') }}</label>
            <input
                id="name"
                name="name"
                type="text"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2">{{ __('messages.Email') }}</label>
            <input
                id="email"
                name="email"
                type="email"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            >
            @error('email')
                <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('messages.Your email address is unverified.') }}

                        <button form="send-verification" class="text-accent-amber hover:text-accent-coral underline text-sm">
                            {{ __('messages.Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-accent-emerald">{{ __('messages.A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-accent-amber to-accent-coral rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                {{ __('messages.Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-accent-emerald">
                    {{ __('messages.Saved!') }}
                </p>
            @endif
        </div>
    </form>
</section>