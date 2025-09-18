@extends('layouts.app', ['title' => __('Edit Equipment')])

@section('content')
<div id="equipment-edit-app">
    <!-- Header -->
    <div class="d-flex align-center mb-6">
        <v-btn
            icon="mdi-arrow-left"
            variant="text"
            class="mr-3"
            :href="`/equipment/${equipment.id}`"
        ></v-btn>
        <div>
            <h2 class="text-h4 font-weight-bold">{{ __('Edit Equipment') }}</h2>
            <p class="text-body-1 text-grey">{{ __('Update equipment information') }}</p>
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
                            {{ __('Update Equipment') }}
                        </v-btn>
                        <v-btn
                            variant="outlined"
                            block
                            :href="`/equipment/${equipment.id}`"
                            class="mb-3"
                        >
                            {{ __('Cancel') }}
                        </v-btn>
                        @can('delete', App\Models\Equipment::class)
                        <v-btn
                            color="error"
                            variant="outlined"
                            block
                            prepend-icon="mdi-delete"
                            @click="confirmDelete"
                        >
                            {{ __('Delete Equipment') }}
                        </v-btn>
                        @endcan
                    </v-card-text>
                </v-card>

                <!-- Equipment Image -->
                <v-card class="mb-6">
                    <v-card-title>{{ __('Equipment Image') }}</v-card-title>
                    <v-card-text>
                        <div class="text-center mb-4">
                            <v-avatar size="150" color="grey-lighten-3">
                                <v-img
                                    v-if="imagePreview || equipment.image_url"
                                    :src="imagePreview || equipment.image_url"
                                    cover
                                ></v-img>
                                <v-icon v-else size="60" color="grey">mdi-camera</v-icon>
                            </v-avatar>
                        </div>
                        <v-file-input
                            v-model="form.image"
                            :label="'{{ __('Upload New Image') }}'"
                            accept="image/*"
                            variant="outlined"
                            prepend-icon=""
                            prepend-inner-icon="mdi-camera"
                            @change="handleImageUpload"
                            :error-messages="errors.image"
                        ></v-file-input>
                        <div v-if="equipment.image_url && !imagePreview" class="text-center mt-2">
                            <v-btn
                                size="small"
                                variant="text"
                                color="error"
                                @click="removeImage"
                            >
                                {{ __('Remove Current Image') }}
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>

                <!-- Quick Stats -->
                <v-card class="mb-6">
                    <v-card-title>{{ __('Quick Stats') }}</v-card-title>
                    <v-card-text>
                        <div class="d-flex justify-space-between align-center mb-3">
                            <span class="text-body-2">{{ __('Total Reservations') }}</span>
                            <v-chip color="primary" variant="tonal" size="small">
                                @{{ equipment.stats?.totalReservations || 0 }}
                            </v-chip>
                        </div>
                        <div class="d-flex justify-space-between align-center mb-3">
                            <span class="text-body-2">{{ __('Maintenance Count') }}</span>
                            <v-chip color="warning" variant="tonal" size="small">
                                @{{ equipment.stats?.maintenanceCount || 0 }}
                            </v-chip>
                        </div>
                        <div class="d-flex justify-space-between align-center">
                            <span class="text-body-2">{{ __('Last Updated') }}</span>
                            <span class="text-body-2 text-grey">@{{ formatDate(equipment.updated_at) }}</span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-form>

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="deleteDialog" max-width="400">
        <v-card>
            <v-card-title class="text-h5">{{ __('Confirm Delete') }}</v-card-title>
            <v-card-text>
                {{ __('Are you sure you want to delete this equipment? This action cannot be undone and will remove all associated reservations and maintenance records.') }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="deleteDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="error" @click="deleteEquipment" :loading="deleteLoading">
                    {{ __('Delete') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
@endsection

@push('scripts')
<script>
const equipmentEditApp = createApp({
    data() {
        return {
            loading: false,
            deleteLoading: false,
            deleteDialog: false,
            imagePreview: null,
            equipment: {},
            form: {
                name: '',
                model: '',
                serial_number: '',
                category: '',
                description: '',
                location: '',
                status: '',
                purchase_date: '',
                purchase_price: '',
                supplier: '',
                warranty_expiry: '',
                usage_instructions: '',
                maintenance_interval: '',
                next_maintenance: '',
                image: null,
                remove_image: false
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
                { title: '{{ __("Out of Order") }}', value: 'out_of_order' },
                { title: '{{ __("Reserved") }}', value: 'reserved' }
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
    mounted() {
        this.fetchEquipment();
    },
    methods: {
        async fetchEquipment() {
            try {
                const equipmentId = {{ $equipment->id ?? 1 }};
                const response = await axios.get(`/api/v1/equipment/${equipmentId}`);
                this.equipment = response.data.data;

                // Populate form with existing data
                this.form = {
                    name: this.equipment.name || '',
                    model: this.equipment.model || '',
                    serial_number: this.equipment.serial_number || '',
                    category: this.equipment.category || '',
                    description: this.equipment.description || '',
                    location: this.equipment.location || '',
                    status: this.equipment.status || '',
                    purchase_date: this.equipment.purchase_date || '',
                    purchase_price: this.equipment.purchase_price || '',
                    supplier: this.equipment.supplier || '',
                    warranty_expiry: this.equipment.warranty_expiry || '',
                    usage_instructions: this.equipment.usage_instructions || '',
                    maintenance_interval: this.equipment.maintenance_interval || '',
                    next_maintenance: this.equipment.next_maintenance || '',
                    image: null,
                    remove_image: false
                };
            } catch (error) {
                console.error('Error fetching equipment:', error);
            }
        },
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

                // Add method override for PUT request
                formData.append('_method', 'PUT');

                const response = await axios.post(`/api/v1/equipment/${this.equipment.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Redirect to equipment details page
                window.location.href = `/equipment/${this.equipment.id}`;

            } catch (error) {
                this.loading = false;

                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    console.error('Error updating equipment:', error);
                }
            }
        },
        handleImageUpload(event) {
            const file = event.target.files?.[0];
            if (file) {
                this.form.image = file;
                this.form.remove_image = false;

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
        },
        removeImage() {
            this.form.remove_image = true;
            this.form.image = null;
            this.imagePreview = null;
        },
        confirmDelete() {
            this.deleteDialog = true;
        },
        async deleteEquipment() {
            this.deleteLoading = true;
            try {
                await axios.delete(`/api/v1/equipment/${this.equipment.id}`);
                window.location.href = '/equipment';
            } catch (error) {
                this.deleteLoading = false;
                console.error('Error deleting equipment:', error);
            }
        },
        formatDate(date) {
            if (!date) return '-';
            return new Date(date).toLocaleDateString();
        }
    }
});

equipmentEditApp.use(vuetify);
equipmentEditApp.mount('#equipment-edit-app');
</script>
@endpush