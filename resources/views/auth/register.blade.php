@extends('layouts.guest', ['title' => __('Register')])

@section('content')
<div id="register-app">
    <v-form @submit.prevent="register" ref="registerForm">
        <div class="text-center mb-6">
            <h3 class="text-h5 font-weight-bold">
                {{ __('Create Account') }}
            </h3>
            <p class="text-body-2 text-grey">
                {{ __('Join the SGLR research community') }}
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

        <!-- Success Message -->
        <v-alert
            v-if="successMessage"
            type="success"
            variant="tonal"
            class="mb-4"
        >
            @{{ successMessage }}
        </v-alert>

        <!-- Name Field -->
        <v-text-field
            v-model="form.name"
            :label="'{{ __('Full Name') }}'"
            :rules="nameRules"
            prepend-inner-icon="mdi-account"
            variant="outlined"
            class="mb-4"
            required
            :error-messages="errors.name"
        ></v-text-field>

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

        <!-- Phone Field -->
        <v-text-field
            v-model="form.phone"
            :label="'{{ __('Phone Number') }}'"
            prepend-inner-icon="mdi-phone"
            variant="outlined"
            class="mb-4"
            :error-messages="errors.phone"
        ></v-text-field>

        <!-- Role Selection -->
        <v-select
            v-model="form.role"
            :label="'{{ __('Account Type') }}'"
            :items="roleOptions"
            :rules="roleRules"
            prepend-inner-icon="mdi-account-group"
            variant="outlined"
            class="mb-4"
            required
            :error-messages="errors.role"
        ></v-select>

        <!-- Research Domain (for researchers) -->
        <v-text-field
            v-if="form.role === 'researcher'"
            v-model="form.research_domain"
            :label="'{{ __('Research Domain') }}'"
            prepend-inner-icon="mdi-flask"
            variant="outlined"
            class="mb-4"
            :error-messages="errors.research_domain"
        ></v-text-field>

        <!-- ORCID ID (for researchers) -->
        <v-text-field
            v-if="form.role === 'researcher'"
            v-model="form.orcid_id"
            :label="'{{ __('ORCID ID (Optional)') }}'"
            prepend-inner-icon="mdi-identifier"
            variant="outlined"
            class="mb-4"
            placeholder="0000-0000-0000-0000"
            :error-messages="errors.orcid_id"
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

        <!-- Confirm Password Field -->
        <v-text-field
            v-model="form.password_confirmation"
            :label="'{{ __('Confirm Password') }}'"
            :rules="confirmPasswordRules"
            :type="showConfirmPassword ? 'text' : 'password'"
            :append-inner-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showConfirmPassword = !showConfirmPassword"
            prepend-inner-icon="mdi-lock-check"
            variant="outlined"
            class="mb-4"
            required
            :error-messages="errors.password_confirmation"
        ></v-text-field>

        <!-- Terms and Conditions -->
        <v-checkbox
            v-model="form.terms"
            :rules="termsRules"
            class="mb-4"
        >
            <template v-slot:label>
                <span class="text-body-2">
                    {{ __('I agree to the') }}
                    <a href="/terms" target="_blank" class="text-primary">{{ __('Terms of Service') }}</a>
                    {{ __('and') }}
                    <a href="/privacy" target="_blank" class="text-primary">{{ __('Privacy Policy') }}</a>
                </span>
            </template>
        </v-checkbox>

        <!-- Register Button -->
        <v-btn
            type="submit"
            color="primary"
            block
            size="large"
            :loading="loading"
            class="mb-4"
        >
            {{ __('Create Account') }}
        </v-btn>

        <!-- Login Link -->
        <div class="text-center">
            <span class="text-body-2 text-grey">{{ __('Already have an account?') }}</span>
            <v-btn
                variant="text"
                color="primary"
                href="{{ route('login') }}"
                class="ml-2"
            >
                {{ __('Sign In') }}
            </v-btn>
        </div>
    </v-form>
</div>
@endsection

@push('scripts')
<script>
const registerApp = createApp({
    data() {
        return {
            loading: false,
            showPassword: false,
            showConfirmPassword: false,
            errorMessage: '',
            successMessage: '',
            form: {
                name: '',
                email: '',
                phone: '',
                role: 'visitor',
                research_domain: '',
                orcid_id: '',
                password: '',
                password_confirmation: '',
                terms: false
            },
            errors: {},
            roleOptions: [
                { title: '{{ __("Researcher") }}', value: 'researcher' },
                { title: '{{ __("Visitor") }}', value: 'visitor' }
            ],
            nameRules: [
                v => !!v || '{{ __("Name is required") }}',
                v => v.length >= 2 || '{{ __("Name must be at least 2 characters") }}'
            ],
            emailRules: [
                v => !!v || '{{ __("Email is required") }}',
                v => /.+@.+\..+/.test(v) || '{{ __("Email must be valid") }}'
            ],
            roleRules: [
                v => !!v || '{{ __("Account type is required") }}'
            ],
            passwordRules: [
                v => !!v || '{{ __("Password is required") }}',
                v => v.length >= 8 || '{{ __("Password must be at least 8 characters") }}',
                v => /(?=.*[a-z])/.test(v) || '{{ __("Password must contain lowercase letter") }}',
                v => /(?=.*[A-Z])/.test(v) || '{{ __("Password must contain uppercase letter") }}',
                v => /(?=.*\d)/.test(v) || '{{ __("Password must contain number") }}'
            ],
            termsRules: [
                v => !!v || '{{ __("You must accept the terms and conditions") }}'
            ]
        }
    },
    computed: {
        confirmPasswordRules() {
            return [
                v => !!v || '{{ __("Password confirmation is required") }}',
                v => v === this.form.password || '{{ __("Passwords do not match") }}'
            ];
        }
    },
    methods: {
        async register() {
            if (!this.$refs.registerForm.validate()) return;

            this.loading = true;
            this.errorMessage = '';
            this.successMessage = '';
            this.errors = {};

            try {
                const response = await axios.post('/api/v1/auth/register', this.form);

                this.successMessage = '{{ __("Account created successfully! Please check your email for verification.") }}';

                // Reset form
                this.form = {
                    name: '',
                    email: '',
                    phone: '',
                    role: 'visitor',
                    research_domain: '',
                    orcid_id: '',
                    password: '',
                    password_confirmation: '',
                    terms: false
                };

                // Redirect to login after 3 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}';
                }, 3000);

            } catch (error) {
                this.loading = false;

                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors || {};
                    this.errorMessage = '{{ __("Please correct the errors below") }}';
                } else {
                    this.errorMessage = '{{ __("An error occurred. Please try again.") }}';
                }
            }
        }
    }
});

registerApp.use(vuetify);
registerApp.mount('#register-app');
</script>
@endpush