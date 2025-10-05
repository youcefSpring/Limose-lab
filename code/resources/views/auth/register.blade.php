@extends('layouts.guest', ['title' => __('Register')])

@section('content')
<div class="text-center mb-4">
    <h3 class="fw-bold mb-2 text-gradient">{{ __('Create Account') }}</h3>
    <p class="text-muted">{{ __('Join the SGLR research community') }}</p>
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

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div id="register-error" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none;">
                <span id="error-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div id="register-success" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
                <span id="success-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Full Name') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autocomplete="name"
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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
                               autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Phone Field -->
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel"
                               class="form-control @error('phone') is-invalid @enderror"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               autocomplete="tel">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Department Field -->
                <div class="mb-3">
                    <label for="department" class="form-label">{{ __('Department') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <input type="text"
                               class="form-control @error('department') is-invalid @enderror"
                               id="department"
                               name="department"
                               value="{{ old('department') }}"
                               autocomplete="organization">
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Position Field -->
                <div class="mb-3">
                    <label for="position" class="form-label">{{ __('Position') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                        <input type="text"
                               class="form-control @error('position') is-invalid @enderror"
                               id="position"
                               name="position"
                               value="{{ old('position') }}"
                               autocomplete="organization-title">
                        @error('position')
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
                               autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">
                        {{ __('Password must be at least 8 characters long') }}
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                            <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror"
                               type="checkbox"
                               name="terms"
                               id="terms"
                               {{ old('terms') ? 'checked' : '' }}
                               required>
                        <label class="form-check-label" for="terms">
                            {{ __('I agree to the') }}
                            <a href="{{ route('frontend.terms') }}" target="_blank" class="text-decoration-none">{{ __('Terms of Service') }}</a>
                            {{ __('and') }}
                            <a href="{{ route('frontend.privacy') }}" target="_blank" class="text-decoration-none">{{ __('Privacy Policy') }}</a>
                        </label>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-primary w-100 mb-4" id="registerBtn">
                    <span class="spinner-border spinner-border-sm me-2" id="registerSpinner" style="display: none;"></span>
                    {{ __('Create Account') }}
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <span class="text-muted">{{ __('Already have an account?') }}</span>
                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none fw-bold">
                    {{ __('Sign In') }}
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

    // Toggle confirm password visibility
    $('#toggleConfirmPassword').on('click', function() {
        const passwordField = $('#password_confirmation');
        const toggleIcon = $('#toggleConfirmIcon');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Handle form submission
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = $('#registerBtn');
        const spinner = $('#registerSpinner');
        const errorAlert = $('#register-error');
        const successAlert = $('#register-success');

        // Validate form before submission
        if (!validateForm()) {
            return;
        }

        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.show();
        errorAlert.removeClass('show').hide();
        successAlert.removeClass('show').hide();

        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Submit form via AJAX for better error handling
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show success message
                $('#success-message').text('{{ __("Account created successfully! Redirecting to login...") }}');
                successAlert.addClass('show').fadeIn();

                // Reset form
                form[0].reset();

                // Redirect to login after 2 seconds
                setTimeout(function() {
                    window.location.href = '{{ route("login") }}';
                }, 2000);
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

                    $('#error-message').text('{{ __("Please correct the errors below") }}');
                    errorAlert.addClass('show').fadeIn();
                } else {
                    // General error
                    let errorMessage = '{{ __("An error occurred. Please try again.") }}';

                    if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    $('#error-message').text(errorMessage);
                    errorAlert.addClass('show').fadeIn();
                }
            }
        });
    });

    // Form validation function
    function validateForm() {
        let isValid = true;

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Name validation
        const name = $('#name').val().trim();
        if (!name) {
            showFieldError('#name', '{{ __("Name is required") }}');
            isValid = false;
        } else if (name.length < 2) {
            showFieldError('#name', '{{ __("Name must be at least 2 characters") }}');
            isValid = false;
        }

        // Email validation
        const email = $('#email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showFieldError('#email', '{{ __("Email is required") }}');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            showFieldError('#email', '{{ __("Email must be valid") }}');
            isValid = false;
        }

        // Password validation
        const password = $('#password').val();
        if (!password) {
            showFieldError('#password', '{{ __("Password is required") }}');
            isValid = false;
        } else if (password.length < 8) {
            showFieldError('#password', '{{ __("Password must be at least 8 characters") }}');
            isValid = false;
        }

        // Password confirmation validation
        const passwordConfirmation = $('#password_confirmation').val();
        if (!passwordConfirmation) {
            showFieldError('#password_confirmation', '{{ __("Password confirmation is required") }}');
            isValid = false;
        } else if (password !== passwordConfirmation) {
            showFieldError('#password_confirmation', '{{ __("Passwords do not match") }}');
            isValid = false;
        }

        // Terms validation
        if (!$('#terms').is(':checked')) {
            showFieldError('#terms', '{{ __("You must accept the terms and conditions") }}');
            isValid = false;
        }

        return isValid;
    }

    // Helper function to show field errors
    function showFieldError(selector, message) {
        const field = $(selector);
        field.addClass('is-invalid');
        field.after(`<div class="invalid-feedback">${message}</div>`);
    }

    // Real-time validation
    $('#name').on('blur', function() {
        const name = $(this).val().trim();
        if (name && name.length < 2) {
            showFieldError('#name', '{{ __("Name must be at least 2 characters") }}');
        } else {
            $(this).removeClass('is-invalid').siblings('.invalid-feedback').remove();
        }
    });

    $('#email').on('blur', function() {
        const email = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            showFieldError('#email', '{{ __("Please enter a valid email address") }}');
        } else {
            $(this).removeClass('is-invalid').siblings('.invalid-feedback').remove();
        }
    });

    $('#password').on('blur', function() {
        const password = $(this).val();
        if (password && password.length < 8) {
            showFieldError('#password', '{{ __("Password must be at least 8 characters") }}');
        } else {
            $(this).removeClass('is-invalid').siblings('.invalid-feedback').remove();
        }
    });

    $('#password_confirmation').on('blur', function() {
        const password = $('#password').val();
        const passwordConfirmation = $(this).val();
        if (passwordConfirmation && password !== passwordConfirmation) {
            showFieldError('#password_confirmation', '{{ __("Passwords do not match") }}');
        } else {
            $(this).removeClass('is-invalid').siblings('.invalid-feedback').remove();
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