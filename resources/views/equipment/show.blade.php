@extends('layouts.app', ['title' => __('Equipment Details')])

@section('content')
<div id="equipment-show-app">
    <!-- Header -->
    <div class="d-flex align-center mb-6">
        <v-btn
            icon="mdi-arrow-left"
            variant="text"
            class="mr-3"
            href="{{ route('equipment.index') }}"
        ></v-btn>
        <div class="flex-grow-1">
            <h2 class="text-h4 font-weight-bold">{{ __('Equipment Details') }}</h2>
            <p class="text-body-1 text-grey">{{ __('View and manage equipment information') }}</p>
        </div>
        @can('update', $equipment ?? new App\Models\Equipment)
        <v-btn
            color="primary"
            prepend-icon="mdi-pencil"
            href="{{ route('equipment.edit', $equipment->id ?? 1) }}"
            class="mr-2"
        >
            {{ __('Edit') }}
        </v-btn>
        @endcan
        <v-btn
            color="success"
            prepend-icon="mdi-calendar-plus"
            @click="openReservationDialog"
            :disabled="equipment.status !== 'operational'"
        >
            {{ __('Reserve') }}
        </v-btn>
    </div>

    <v-row>
        <!-- Equipment Information -->
        <v-col cols="12" lg="8">
            <v-card class="mb-6">
                <v-card-title class="d-flex align-center">
                    <v-avatar color="primary" class="mr-3">
                        <v-icon>mdi-tools</v-icon>
                    </v-avatar>
                    <div>
                        <h3 class="text-h6">@{{ equipment.name }}</h3>
                        <div class="text-caption text-grey">{{ __('Equipment Information') }}</div>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="6">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Model') }}</div>
                                <div class="text-body-1">@{{ equipment.model || '-' }}</div>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Serial Number') }}</div>
                                <div class="text-body-1">@{{ equipment.serial_number || '-' }}</div>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Category') }}</div>
                                <v-chip
                                    :color="getCategoryColor(equipment.category)"
                                    variant="tonal"
                                    size="small"
                                >
                                    @{{ equipment.category }}
                                </v-chip>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Status') }}</div>
                                <v-chip
                                    :color="getStatusColor(equipment.status)"
                                    variant="tonal"
                                    size="small"
                                >
                                    <v-icon start size="16">@{{ getStatusIcon(equipment.status) }}</v-icon>
                                    @{{ getStatusText(equipment.status) }}
                                </v-chip>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Location') }}</div>
                                <div class="d-flex align-center">
                                    <v-icon size="16" class="mr-1">mdi-map-marker</v-icon>
                                    @{{ equipment.location || '-' }}
                                </div>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Purchase Date') }}</div>
                                <div class="text-body-1">@{{ formatDate(equipment.purchase_date) || '-' }}</div>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Description') }}</div>
                                <div class="text-body-1">@{{ equipment.description || '-' }}</div>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <div class="mb-4">
                                <div class="text-caption text-grey mb-1">{{ __('Usage Instructions') }}</div>
                                <div class="text-body-1 white-space-pre-line">@{{ equipment.usage_instructions || '-' }}</div>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Maintenance History -->
            <v-card class="mb-6">
                <v-card-title>
                    <v-icon class="mr-2">mdi-wrench</v-icon>
                    {{ __('Maintenance History') }}
                </v-card-title>
                <v-card-text>
                    <v-data-table
                        :headers="maintenanceHeaders"
                        :items="maintenanceHistory"
                        :loading="maintenanceLoading"
                        item-value="id"
                        class="elevation-0"
                    >
                        <template #item.type="{ item }">
                            <v-chip
                                :color="getMaintenanceTypeColor(item.type)"
                                variant="tonal"
                                size="small"
                            >
                                @{{ getMaintenanceTypeText(item.type) }}
                            </v-chip>
                        </template>
                        <template #item.performed_at="{ item }">
                            @{{ formatDate(item.performed_at) }}
                        </template>
                        <template #item.cost="{ item }">
                            <span v-if="item.cost">@{{ formatCurrency(item.cost) }}</span>
                            <span v-else class="text-grey">-</span>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-col>

        <!-- Sidebar -->
        <v-col cols="12" lg="4">
            <!-- Quick Stats -->
            <v-card class="mb-6">
                <v-card-title>{{ __('Quick Stats') }}</v-card-title>
                <v-card-text>
                    <div class="d-flex justify-space-between align-center mb-3">
                        <span class="text-body-2">{{ __('Total Reservations') }}</span>
                        <v-chip color="primary" variant="tonal" size="small">
                            @{{ stats.totalReservations }}
                        </v-chip>
                    </div>
                    <div class="d-flex justify-space-between align-center mb-3">
                        <span class="text-body-2">{{ __('This Month') }}</span>
                        <v-chip color="info" variant="tonal" size="small">
                            @{{ stats.monthlyReservations }}
                        </v-chip>
                    </div>
                    <div class="d-flex justify-space-between align-center mb-3">
                        <span class="text-body-2">{{ __('Maintenance Count') }}</span>
                        <v-chip color="warning" variant="tonal" size="small">
                            @{{ stats.maintenanceCount }}
                        </v-chip>
                    </div>
                    <div class="d-flex justify-space-between align-center">
                        <span class="text-body-2">{{ __('Last Used') }}</span>
                        <span class="text-body-2 text-grey">@{{ formatDate(stats.lastUsed) || 'Never' }}</span>
                    </div>
                </v-card-text>
            </v-card>

            <!-- Upcoming Maintenance -->
            <v-card class="mb-6" v-if="equipment.next_maintenance">
                <v-card-title class="text-warning">
                    <v-icon class="mr-2">mdi-calendar-alert</v-icon>
                    {{ __('Upcoming Maintenance') }}
                </v-card-title>
                <v-card-text>
                    <div class="text-h6 mb-2">@{{ formatDate(equipment.next_maintenance) }}</div>
                    <div class="text-body-2 text-grey mb-3">
                        @{{ getMaintenanceTimeRemaining(equipment.next_maintenance) }}
                    </div>
                    <v-btn
                        color="warning"
                        variant="outlined"
                        block
                        prepend-icon="mdi-calendar-edit"
                        @click="scheduleMaintenance"
                    >
                        {{ __('Schedule Maintenance') }}
                    </v-btn>
                </v-card-text>
            </v-card>

            <!-- Current Reservation -->
            <v-card v-if="currentReservation">
                <v-card-title class="text-info">
                    <v-icon class="mr-2">mdi-calendar-clock</v-icon>
                    {{ __('Current Reservation') }}
                </v-card-title>
                <v-card-text>
                    <div class="mb-3">
                        <div class="text-caption text-grey">{{ __('Reserved by') }}</div>
                        <div class="text-body-1">@{{ currentReservation.user.name }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-caption text-grey">{{ __('Period') }}</div>
                        <div class="text-body-2">
                            @{{ formatDateTime(currentReservation.start_date) }} -<br>
                            @{{ formatDateTime(currentReservation.end_date) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="text-caption text-grey">{{ __('Purpose') }}</div>
                        <div class="text-body-2">@{{ currentReservation.purpose }}</div>
                    </div>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <!-- Reservation Dialog -->
    <v-dialog v-model="reservationDialog" max-width="600">
        <v-card>
            <v-card-title>
                <span class="text-h5">{{ __('Reserve Equipment') }}</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="reservationForm">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="reservationForm.start_date"
                                :label="'{{ __('Start Date') }}'"
                                type="datetime-local"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="reservationForm.end_date"
                                :label="'{{ __('End Date') }}'"
                                type="datetime-local"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                v-model="reservationForm.purpose"
                                :label="'{{ __('Purpose') }}'"
                                variant="outlined"
                                rows="3"
                                required
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="reservationDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="primary" @click="submitReservation" :loading="reservationLoading">
                    {{ __('Reserve') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
@endsection

@push('scripts')
<script>
const equipmentShowApp = createApp({
    data() {
        return {
            equipment: {},
            stats: {},
            currentReservation: null,
            maintenanceHistory: [],
            maintenanceLoading: false,
            maintenanceHeaders: [
                { title: '{{ __("Type") }}', key: 'type' },
                { title: '{{ __("Date") }}', key: 'performed_at' },
                { title: '{{ __("Description") }}', key: 'description' },
                { title: '{{ __("Cost") }}', key: 'cost' },
                { title: '{{ __("Technician") }}', key: 'technician' }
            ],
            reservationDialog: false,
            reservationForm: {
                start_date: '',
                end_date: '',
                purpose: ''
            },
            reservationLoading: false
        }
    },
    mounted() {
        this.fetchEquipmentDetails();
    },
    methods: {
        async fetchEquipmentDetails() {
            try {
                const equipmentId = {{ $equipment->id ?? 1 }};
                const response = await axios.get(`/api/v1/equipment/${equipmentId}`);
                this.equipment = response.data.data;
                this.stats = response.data.data.stats || {};
                this.currentReservation = response.data.data.current_reservation;

                await this.fetchMaintenanceHistory();
            } catch (error) {
                console.error('Error fetching equipment details:', error);
            }
        },
        async fetchMaintenanceHistory() {
            this.maintenanceLoading = true;
            try {
                const response = await axios.get(`/api/v1/equipment/${this.equipment.id}/maintenance`);
                this.maintenanceHistory = response.data.data;
            } catch (error) {
                console.error('Error fetching maintenance history:', error);
            } finally {
                this.maintenanceLoading = false;
            }
        },
        getCategoryColor(category) {
            const colors = {
                analytical: 'blue',
                microscopy: 'green',
                spectroscopy: 'purple',
                chromatography: 'orange',
                safety: 'red',
                general: 'grey'
            };
            return colors[category] || 'grey';
        },
        getStatusColor(status) {
            const colors = {
                operational: 'success',
                maintenance: 'warning',
                out_of_order: 'error',
                reserved: 'info'
            };
            return colors[status] || 'grey';
        },
        getStatusIcon(status) {
            const icons = {
                operational: 'mdi-check-circle',
                maintenance: 'mdi-wrench',
                out_of_order: 'mdi-alert-circle',
                reserved: 'mdi-calendar-clock'
            };
            return icons[status] || 'mdi-help-circle';
        },
        getStatusText(status) {
            const texts = {
                operational: '{{ __("Operational") }}',
                maintenance: '{{ __("Maintenance") }}',
                out_of_order: '{{ __("Out of Order") }}',
                reserved: '{{ __("Reserved") }}'
            };
            return texts[status] || status;
        },
        getMaintenanceTypeColor(type) {
            const colors = {
                preventive: 'info',
                corrective: 'warning',
                emergency: 'error',
                calibration: 'purple'
            };
            return colors[type] || 'grey';
        },
        getMaintenanceTypeText(type) {
            const texts = {
                preventive: '{{ __("Preventive") }}',
                corrective: '{{ __("Corrective") }}',
                emergency: '{{ __("Emergency") }}',
                calibration: '{{ __("Calibration") }}'
            };
            return texts[type] || type;
        },
        formatDate(date) {
            if (!date) return null;
            return new Date(date).toLocaleDateString();
        },
        formatDateTime(date) {
            if (!date) return null;
            return new Date(date).toLocaleString();
        },
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        },
        getMaintenanceTimeRemaining(date) {
            const now = new Date();
            const maintenanceDate = new Date(date);
            const diffDays = Math.ceil((maintenanceDate - now) / (1000 * 60 * 60 * 24));

            if (diffDays < 0) return '{{ __("Overdue") }}';
            if (diffDays === 0) return '{{ __("Due today") }}';
            if (diffDays === 1) return '{{ __("Due tomorrow") }}';
            if (diffDays <= 7) return `{{ __("Due in") }} ${diffDays} {{ __("days") }}`;
            return `{{ __("Due in") }} ${diffDays} {{ __("days") }}`;
        },
        openReservationDialog() {
            this.reservationForm = {
                start_date: '',
                end_date: '',
                purpose: ''
            };
            this.reservationDialog = true;
        },
        async submitReservation() {
            this.reservationLoading = true;
            try {
                await axios.post(`/api/v1/equipment/${this.equipment.id}/reservations`, {
                    ...this.reservationForm,
                    equipment_id: this.equipment.id
                });

                this.reservationDialog = false;
                await this.fetchEquipmentDetails();
            } catch (error) {
                console.error('Error creating reservation:', error);
            } finally {
                this.reservationLoading = false;
            }
        },
        scheduleMaintenance() {
            // Navigate to maintenance scheduling page
            window.location.href = `/equipment/${this.equipment.id}/maintenance/schedule`;
        }
    }
});

equipmentShowApp.use(vuetify);
equipmentShowApp.mount('#equipment-show-app');
</script>
@endpush

@push('styles')
<style>
.white-space-pre-line {
    white-space: pre-line;
}
</style>
@endpush