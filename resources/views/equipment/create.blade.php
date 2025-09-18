@extends('layouts.app', ['title' => __('Add Equipment')])

@section('content')
<div id="equipment-create-app">
    <!-- Header -->
    <div class="d-flex align-center mb-6">
        <v-btn
            icon="mdi-arrow-left"
            variant="text"
            class="mr-3"
            href="{{ route('equipment.index') }}"
        ></v-btn>
        <div>
            <h2 class="text-h4 font-weight-bold">{{ __('Add Equipment') }}</h2>
            <p class="text-body-1 text-grey">{{ __('Register new laboratory equipment') }}</p>
        </div>
    </div>

    <v-form ref="equipmentForm" @submit.prevent="submitForm">
        <v-row>
            <!-- Main Form -->
            <v-col cols="12" lg="8">
                <!-- Basic Information -->
                <v-card class="mb-6">
                    <v-card-title>
                        <v-icon class="mr-2">mdi-information</v-icon>
                        {{ __('Basic Information') }}
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.name"
                                    :label="'{{ __('Equipment Name') }}'"
                                    :rules="nameRules"
                                    variant="outlined"
                                    required
                                    :error-messages="errors.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.model"
                                    :label="'{{ __('Model') }}'"
                                    variant="outlined"
                                    :error-messages="errors.model"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.serial_number"
                                    :label="'{{ __('Serial Number') }}'"
                                    variant="outlined"
                                    :error-messages="errors.serial_number"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="form.category"
                                    :label="'{{ __('Category') }}'"
                                    :items="categories"
                                    :rules="categoryRules"
                                    variant="outlined"
                                    required
                                    :error-messages="errors.category"
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    v-model="form.description"
                                    :label="'{{ __('Description') }}'"
                                    variant="outlined"
                                    rows="3"
                                    :error-messages="errors.description"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <!-- Location and Status -->
                <v-card class="mb-6">
                    <v-card-title>
                        <v-icon class="mr-2">mdi-map-marker</v-icon>
                        {{ __('Location and Status') }}
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.location"
                                    :label="'{{ __('Location') }}'"
                                    :rules="locationRules"
                                    variant="outlined"
                                    prepend-inner-icon="mdi-map-marker"
                                    required
                                    :error-messages="errors.location"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="form.status"
                                    :label="'{{ __('Status') }}'"
                                    :items="statusOptions"
                                    :rules="statusRules"
                                    variant="outlined"
                                    required
                                    :error-messages="errors.status"
                                ></v-select>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <!-- Purchase and Financial Info -->
                <v-card class="mb-6">
                    <v-card-title>
                        <v-icon class="mr-2">mdi-cash</v-icon>
                        {{ __('Purchase Information') }}
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.purchase_date"
                                    :label="'{{ __('Purchase Date') }}'"
                                    type="date"
                                    variant="outlined"
                                    :error-messages="errors.purchase_date"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.purchase_price"
                                    :label="'{{ __('Purchase Price') }}'"
                                    type="number"
                                    variant="outlined"
                                    prefix="$"
                                    :error-messages="errors.purchase_price"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.supplier"
                                    :label="'{{ __('Supplier') }}'"
                                    variant="outlined"
                                    :error-messages="errors.supplier"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.warranty_expiry"
                                    :label="'{{ __('Warranty Expiry') }}'"
                                    type="date"
                                    variant="outlined"
                                    :error-messages="errors.warranty_expiry"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <!-- Usage Instructions -->
                <v-card class="mb-6">
                    <v-card-title>
                        <v-icon class="mr-2">mdi-book-open</v-icon>
                        {{ __('Usage Instructions') }}
                    </v-card-title>
                    <v-card-text>
                        <v-textarea
                            v-model="form.usage_instructions"
                            :label="'{{ __('Usage Instructions') }}'"
                            variant="outlined"
                            rows="6"
                            :hint="'{{ __('Provide detailed instructions on how to use this equipment safely and effectively') }}'"
                            persistent-hint
                            :error-messages="errors.usage_instructions"
                        ></v-textarea>
                    </v-card-text>
                </v-card>

                <!-- Maintenance Schedule -->
                <v-card class="mb-6">
                    <v-card-title>
                        <v-icon class="mr-2">mdi-calendar-clock</v-icon>
                        {{ __('Maintenance Schedule') }}
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.maintenance_interval"
                                    :label="'{{ __('Maintenance Interval (days)') }}'"
                                    type="number"
                                    variant="outlined"
                                    :hint="'{{ __('How often should this equipment be maintained?') }}'"
                                    persistent-hint
                                    :error-messages="errors.maintenance_interval"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="form.next_maintenance"
                                    :label="'{{ __('Next Maintenance Date') }}'"
                                    type="date"
                                    variant="outlined"
                                    :error-messages="errors.next_maintenance"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

            <!-- Sidebar -->
            <v-col cols="12" lg="4">
                <!-- Save Actions -->
                <v-card class="mb-6">
                    <v-card-title>{{ __('Actions') }}</v-card-title>
                    <v-card-text>
                        <v-btn
                            type="submit"
                            color="primary"
                            block
                            size="large"
                            :loading="loading"
                            prepend-icon="mdi-content-save"
                            class="mb-3"
                        >
                            {{ __('Save Equipment') }}
                        </v-btn>
                        <v-btn
                            variant="outlined"
                            block
                            href="{{ route('equipment.index') }}"
                        >
                            {{ __('Cancel') }}
                        </v-btn>
                    </v-card-text>
                </v-card>

                <!-- Equipment Image -->
                <v-card class="mb-6">
                    <v-card-title>{{ __('Equipment Image') }}</v-card-title>
                    <v-card-text>
                        <div class="text-center mb-4">
                            <v-avatar size="150" color="grey-lighten-3">
                                <v-img
                                    v-if="imagePreview"
                                    :src="imagePreview"
                                    cover
                                ></v-img>
                                <v-icon v-else size="60" color="grey">mdi-camera</v-icon>
                            </v-avatar>
                        </div>
                        <v-file-input
                            v-model="form.image"
                            :label="'{{ __('Upload Image') }}'"
                            accept="image/*"
                            variant="outlined"
                            prepend-icon=""
                            prepend-inner-icon="mdi-camera"
                            @change="handleImageUpload"
                            :error-messages="errors.image"
                        ></v-file-input>
                    </v-card-text>
                </v-card>

                <!-- Quick Tips -->
                <v-card>
                    <v-card-title>
                        <v-icon class="mr-2">mdi-lightbulb</v-icon>
                        {{ __('Tips') }}
                    </v-card-title>
                    <v-card-text>
                        <v-list density="compact">
                            <v-list-item>
                                <v-list-item-title class="text-body-2">
                                    {{ __('Provide detailed usage instructions to help users operate the equipment safely') }}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title class="text-body-2">
                                    {{ __('Set up regular maintenance schedules to ensure equipment longevity') }}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title class="text-body-2">
                                    {{ __('Include warranty information for future reference') }}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-form>
</div>
@endsection

@push('scripts')
<script>
const equipmentCreateApp = createApp({
    data() {
        return {
            loading: false,
            imagePreview: null,
            form: {
                name: '',
                model: '',
                serial_number: '',
                category: '',
                description: '',
                location: '',
                status: 'operational',
                purchase_date: '',
                purchase_price: '',
                supplier: '',
                warranty_expiry: '',
                usage_instructions: '',
                maintenance_interval: '',
                next_maintenance: '',
                image: null
            },
            errors: {},
            categories: [
                { title: '{{ __("Analytical") }}', value: 'analytical' },
                { title: '{{ __("Microscopy") }}', value: 'microscopy' },
                { title: '{{ __("Spectroscopy") }}', value: 'spectroscopy' },
                { title: '{{ __("Chromatography") }}', value: 'chromatography' },
                { title: '{{ __("Safety") }}', value: 'safety' },
                { title: '{{ __("General") }}', value: 'general' }
            ],
            statusOptions: [
                { title: '{{ __("Operational") }}', value: 'operational' },
                { title: '{{ __("Maintenance") }}', value: 'maintenance' },
                { title: '{{ __("Out of Order") }}', value: 'out_of_order' }
            ],
            nameRules: [
                v => !!v || '{{ __("Equipment name is required") }}',
                v => v.length >= 2 || '{{ __("Name must be at least 2 characters") }}'
            ],
            categoryRules: [
                v => !!v || '{{ __("Category is required") }}'
            ],
            locationRules: [
                v => !!v || '{{ __("Location is required") }}'
            ],
            statusRules: [
                v => !!v || '{{ __("Status is required") }}'
            ]
        }
    },
    methods: {
        async submitForm() {
            if (!this.$refs.equipmentForm.validate()) return;

            this.loading = true;
            this.errors = {};

            try {
                const formData = new FormData();

                // Add all form fields to FormData
                Object.keys(this.form).forEach(key => {
                    if (this.form[key] !== null && this.form[key] !== '') {
                        if (key === 'image' && this.form[key] instanceof File) {
                            formData.append(key, this.form[key]);
                        } else if (key !== 'image') {
                            formData.append(key, this.form[key]);
                        }
                    }
                });

                const response = await axios.post('/api/v1/equipment', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Redirect to equipment details page
                window.location.href = `/equipment/${response.data.data.id}`;

            } catch (error) {
                this.loading = false;

                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    console.error('Error creating equipment:', error);
                }
            }
        },
        handleImageUpload(event) {
            const file = event.target.files?.[0];
            if (file) {
                this.form.image = file;

                // Create preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.form.image = null;
                this.imagePreview = null;
            }
        }
    }
});

equipmentCreateApp.use(vuetify);
equipmentCreateApp.mount('#equipment-create-app');
</script>
@endpush