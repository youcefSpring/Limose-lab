@extends('layouts.guest', ['title' => __('Login')])

@section('content')
<div id="login-app">
    <v-form @submit.prevent="login" ref="loginForm">
        <div class="text-center mb-6">
            <h3 class="text-h5 font-weight-bold">
                {{ __('Sign In') }}
            </h3>
            <p class="text-body-2 text-grey">
                {{ __('Access your SGLR account') }}
            </p>
        </div>

        <!-- Error Messages -->
        <v-alert
            v-if="errorMessage"
            type="error"
            variant="tonal"
            class="mb-4"
            closable
            @click:close="errorMessage = ''"
        >
            @{{ errorMessage }}
        </v-alert>

        <!-- Email Field -->
        <v-text-field
            v-model="form.email"
            :label="'{{ __('Email Address') }}'"
            :rules="emailRules"
            type="email"
            prepend-inner-icon="mdi-email"
            variant="outlined"
            class="mb-4"
            required
            :error-messages="errors.email"
        ></v-text-field>

        <!-- Password Field -->
        <v-text-field
            v-model="form.password"
            :label="'{{ __('Password') }}'"
            :rules="passwordRules"
            :type="showPassword ? 'text' : 'password'"
            :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showPassword = !showPassword"
            prepend-inner-icon="mdi-lock"
            variant="outlined"
            class="mb-4"
            required
            :error-messages="errors.password"
        ></v-text-field>

        <!-- Remember Me -->
        <v-checkbox
            v-model="form.remember"
            :label="'{{ __('Remember me') }}'"
            class="mb-4"
            hide-details
        ></v-checkbox>

        <!-- Login Button -->
        <v-btn
            type="submit"
            color="primary"
            block
            size="large"
            :loading="loading"
            class="mb-4"
        >
            {{ __('Sign In') }}
        </v-btn>

        <!-- Divider -->
        <v-divider class="my-6">
            <template v-slot:default>
                <span class="text-body-2 text-grey">{{ __('or') }}</span>
            </template>
        </v-divider>

        <!-- Additional Actions -->
        <div class="text-center">
            <v-btn
                variant="text"
                color="primary"
                href="{{ route('password.request') }}"
                class="mb-2"
            >
                {{ __('Forgot Password?') }}
            </v-btn>
        </div>

        <div class="text-center">
            <span class="text-body-2 text-grey">{{ __('Don\'t have an account?') }}</span>
            <v-btn
                variant="text"
                color="primary"
                href="{{ route('register') }}"
                class="ml-2"
            >
                {{ __('Register') }}
            </v-btn>
        </div>

        <!-- Guest Access -->
        <v-divider class="my-4"></v-divider>
        <div class="text-center">
            <v-btn
                variant="outlined"
                color="secondary"
                href="{{ route('dashboard.index') }}"
                prepend-icon="mdi-eye"
            >
                {{ __('Continue as Guest') }}
            </v-btn>
        </div>
    </v-form>
</div>
@endsection

@push('scripts')
<script>
const loginApp = createApp({
    data() {
        return {
            loading: false,
            showPassword: false,
            errorMessage: '',
            form: {
                email: '',
                password: '',
                remember: false
            },
            errors: {},
            emailRules: [
                v => !!v || '{{ __("Email is required") }}',
                v => /.+@.+\..+/.test(v) || '{{ __("Email must be valid") }}'
            ],
            passwordRules: [
                v => !!v || '{{ __("Password is required") }}'
            ]
        }
    },
    methods: {
        async login() {
            if (!this.$refs.loginForm.validate()) return;

            this.loading = true;
            this.errorMessage = '';
            this.errors = {};

            try {
                const response = await axios.post('/api/v1/auth/login', {
                    ...this.form,
                    device_name: 'web_browser'
                });

                // Store token
                const token = response.data.data.token;
                localStorage.setItem('auth_token', token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                // Redirect to dashboard
                window.location.href = '{{ route("dashboard.index") }}';

            } catch (error) {
                this.loading = false;

                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else if (error.response?.status === 401) {
                    this.errorMessage = '{{ __("Invalid credentials") }}';
                } else {
                    this.errorMessage = '{{ __("An error occurred. Please try again.") }}';
                }
            }
        }
    },
    mounted() {
        // Check if already logged in
        const token = localStorage.getItem('auth_token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            // Verify token validity
            axios.get('/api/v1/auth/me')
                .then(() => {
                    window.location.href = '{{ route("dashboard.index") }}';
                })
                .catch(() => {
                    localStorage.removeItem('auth_token');
                });
        }
    }
});

loginApp.use(vuetify);
loginApp.mount('#login-app');
</script>
@endpush