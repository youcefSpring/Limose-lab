@props([
    'title' => '',
    'message' => '',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmColor' => 'error',
    'icon' => 'mdi-alert-circle',
    'maxWidth' => '400'
])

<v-dialog
    v-model="dialog"
    max-width="{{ $maxWidth }}"
    persistent
    {{ $attributes }}
>
    <v-card>
        <v-card-title class="d-flex align-center">
            <v-icon
                color="{{ $confirmColor }}"
                size="large"
                class="me-3"
            >
                {{ $icon }}
            </v-icon>
            <span class="text-h6">{{ $title ?: __('Confirm Action') }}</span>
        </v-card-title>

        <v-card-text class="py-4">
            <div class="text-body-1">
                {{ $message ?: __('Are you sure you want to perform this action?') }}
            </div>

            @if(isset($details))
                <div class="mt-4">
                    {{ $details }}
                </div>
            @endif
        </v-card-text>

        <v-card-actions class="px-6 pb-4">
            <v-spacer></v-spacer>

            <v-btn
                variant="text"
                @click="dialog = false"
            >
                {{ $cancelText ?: __('Cancel') }}
            </v-btn>

            <v-btn
                color="{{ $confirmColor }}"
                variant="flat"
                @click="confirm"
                :loading="loading"
            >
                {{ $confirmText ?: __('Confirm') }}
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

<script>
export default {
    data() {
        return {
            dialog: false,
            loading: false,
            resolvePromise: null,
            rejectPromise: null
        }
    },
    methods: {
        show() {
            this.dialog = true;
            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve;
                this.rejectPromise = reject;
            });
        },
        async confirm() {
            if (this.resolvePromise) {
                this.loading = true;
                try {
                    await this.resolvePromise(true);
                } catch (error) {
                    console.error('Error in confirm action:', error);
                } finally {
                    this.loading = false;
                    this.dialog = false;
                    this.resolvePromise = null;
                    this.rejectPromise = null;
                }
            }
        },
        cancel() {
            this.dialog = false;
            if (this.rejectPromise) {
                this.rejectPromise(false);
                this.resolvePromise = null;
                this.rejectPromise = null;
            }
        }
    }
}
</script>