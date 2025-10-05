@extends('layouts.guest', ['title' => __('Login')])

@section('content')
<div class="text-center mb-4">
    <h3 class="fw-bold mb-2 text-gradient">{{ __('Sign In') }}</h3>
    <p class="text-muted">{{ __('Access your SGLR account') }}</p>
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

            <div id="login-error" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none;">
                <span id="error-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
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
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary w-100 mb-4" id="loginBtn">
                    <span class="spinner-border spinner-border-sm me-2" id="loginSpinner" style="display: none;"></span>
                    {{ __('Sign In') }}
                </button>
        </form>

        <!-- Divider -->
        <div class="position-relative my-4">
            <hr class="border-0 bg-secondary" style="height: 1px;">
            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">{{ __('or') }}</span>
        </div>

        <!-- Additional Actions -->
        <div class="text-center mb-3">
            <a href="{{ route('password.request') }}" class="btn btn-link text-decoration-none fw-medium">
                <i class="fas fa-key me-2"></i>{{ __('Forgot Password?') }}
            </a>
        </div>

        <div class="text-center mb-4">
            <span class="text-muted">{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" class="btn btn-link text-decoration-none fw-bold">
                {{ __('Register') }}
            </a>
        </div>

        <!-- Guest Access -->
        <div class="position-relative my-3">
            <hr class="border-0 bg-secondary" style="height: 1px;">
        </div>
        <div class="text-center">
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-eye me-2"></i>{{ __('Continue as Guest') }}
            </a>
        </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').on('click', function() {
        const passwordField = $('#password');
        const toggleIcon = $('#toggleIcon');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Handle form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = $('#loginBtn');
        const spinner = $('#loginSpinner');
        const errorAlert = $('#login-error');

        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.show();
        errorAlert.removeClass('show').hide();

        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Submit form via AJAX for better error handling
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // If successful, redirect will be handled by the server
                window.location.reload();
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false);
                spinner.hide();

                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON?.errors || {};

                    Object.keys(errors).forEach(function(field) {
                        const input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');

                        const errorMessages = errors[field];
                        if (errorMessages && errorMessages.length > 0) {
                            input.after(`<div class="invalid-feedback">${errorMessages[0]}</div>`);
                        }
                    });
                } else {
                    // General error
                    let errorMessage = '{{ __("An error occurred. Please try again.") }}';

                    if (xhr.status === 401) {
                        errorMessage = '{{ __("Invalid credentials") }}';
                    } else if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    $('#error-message').text(errorMessage);
                    errorAlert.addClass('show').fadeIn();
                }
            }
        });
    });

    // Email validation on blur
    $('#email').on('blur', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && !emailRegex.test(email)) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">{{ __("Please enter a valid email address") }}</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Password validation on blur
    $('#password').on('blur', function() {
        const password = $(this).val();

        if (password && password.length < 6) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">{{ __("Password must be at least 6 characters") }}</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Clear validation errors on input
    $('input').on('input', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove();
    });
});
</script>
@endpush