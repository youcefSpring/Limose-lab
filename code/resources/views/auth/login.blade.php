@extends('layouts.guest', ['title' => __('Login')])

@section('content')
<div class="text-center mb-3">
    <h3 class="fw-bold mb-1 text-gradient">{{ __('Sign In') }}</h3>
    <p class="text-muted small">{{ __('Access your SGLR account') }}</p>
</div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="mb-2">
                    <label for="email" class="form-label small">{{ __('Email Address') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-2">
                    <label for="password" class="form-label small">{{ __('Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="remember">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    {{ __('Sign In') }}
                </button>
        </form>

        <!-- Divider -->
        <div class="position-relative my-2">
            <hr class="border-0 bg-secondary" style="height: 1px;">
            <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small">{{ __('or') }}</span>
        </div>

        <!-- Additional Actions -->
        <div class="text-center mb-2">
            <a href="{{ route('password.request') }}" class="btn btn-link text-decoration-none small">
                <i class="fas fa-key me-1"></i>{{ __('Forgot Password?') }}
            </a>
        </div>

        <div class="text-center mb-2">
            <span class="text-muted small">{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" class="btn btn-link text-decoration-none fw-bold small">
                {{ __('Register') }}
            </a>
        </div>

        <!-- Guest Access -->
        <div class="position-relative my-2">
            <hr class="border-0 bg-secondary" style="height: 1px;">
        </div>
        <div class="text-center">
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm small">
                <i class="fas fa-eye me-1"></i>{{ __('Continue as Guest') }}
            </a>
        </div>
@endsection

