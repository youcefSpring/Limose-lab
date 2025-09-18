<!-- Lab Manager Dashboard -->
<v-row class="mb-6">
    <!-- Equipment Stats -->
    <v-col cols="12" sm="6" md="3">
        <v-card color="primary" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.total_equipment || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Total Equipment') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-tools</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" sm="6" md="3">
        <v-card color="success" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.available_equipment || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Available') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-check-circle</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" sm="6" md="3">
        <v-card color="warning" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.pending_reservations || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Pending Requests') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-clock</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" sm="6" md="3">
        <v-card color="error" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.maintenance_due || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Maintenance Due') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-wrench</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Quick Actions -->
<v-row class="mb-6">
    <v-col cols="12">
        <v-card>
            <v-card-title>{{ __('Quick Actions') }}</v-card-title>
            <v-card-text>
                <div class="d-flex flex-wrap ga-4">
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-plus"
                        :to="{ name: 'lab-manager.equipment.create' }"
                    >
                        {{ __('Add Equipment') }}
                    </v-btn>

                    <v-btn
                        color="warning"
                        prepend-icon="mdi-calendar-check"
                        @click="approveReservations"
                    >
                        {{ __('Approve Reservations') }}
                        <v-badge
                            v-if="dashboardData.overview?.pending_reservations > 0"
                            :content="dashboardData.overview.pending_reservations"
                            color="error"
                            inline
                        ></v-badge>
                    </v-btn>

                    <v-btn
                        color="info"
                        prepend-icon="mdi-calendar-plus"
                        :to="{ name: 'events.create' }"
                    >
                        {{ __('Schedule Event') }}
                    </v-btn>

                    <v-btn
                        color="success"
                        prepend-icon="mdi-file-chart"
                        @click="generateReport"
                    >
                        {{ __('Generate Report') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Equipment Status Overview -->
<v-row class="mb-6">
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Equipment Status Distribution') }}</v-card-title>
            <v-card-text>
                <div ref="equipmentStatusChart" style="height: 300px;"></div>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Usage Statistics') }}</v-card-title>
            <v-card-text>
                <v-list density="compact">
                    <v-list-item
                        v-for="stat in equipmentStats"
                        :key="stat.label"
                    >
                        <v-list-item-title>@{{ stat.label }}</v-list-item-title>
                        <template v-slot:append>
                            <v-chip
                                :color="stat.color"
                                size="small"
                                variant="flat"
                            >
                                @{{ stat.value }}@{{ stat.unit }}
                            </v-chip>
                        </template>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Pending Reservations -->
<v-row class="mb-6">
    <v-col cols="12">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>{{ __('Pending Reservations') }}</span>
                <v-btn
                    size="small"
                    variant="text"
                    :to="{ name: 'lab-manager.equipment.reservations' }"
                >
                    {{ __('View All') }}
                </v-btn>
            </v-card-title>
            <v-card-text>
                <x-data-table
                    v-if="dashboardData.pending_approvals?.length > 0"
                    :headers="reservationHeaders"
                    :items="dashboardData.pending_approvals"
                    :items-per-page="5"
                    hide-footer
                >
                    <template v-slot:item.equipment.name="{ item }">
                        <div class="d-flex align-center">
                            <v-avatar size="32" color="primary" class="me-3">
                                <v-icon color="white" size="small">mdi-tools</v-icon>
                            </v-avatar>
                            <div>
                                <div class="font-weight-medium">@{{ item.equipment.name }}</div>
                                <div class="text-caption text-grey">@{{ item.equipment.location }}</div>
                            </div>
                        </div>
                    </template>

                    <template v-slot:item.researcher.full_name="{ item }">
                        <div class="d-flex align-center">
                            <v-avatar size="32" class="me-3">
                                <v-img
                                    :src="item.researcher.photo_url || '/images/default-avatar.png'"
                                    :alt="item.researcher.full_name"
                                ></v-img>
                            </v-avatar>
                            <div>
                                <div class="font-weight-medium">@{{ item.researcher.full_name }}</div>
                                <div class="text-caption text-grey">@{{ item.researcher.research_domain }}</div>
                            </div>
                        </div>
                    </template>

                    <template v-slot:item.start_datetime="{ item }">
                        <div>
                            <div class="font-weight-medium">@{{ formatDate(item.start_datetime) }}</div>
                            <div class="text-caption text-grey">@{{ formatTime(item.start_datetime) }}</div>
                        </div>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex ga-2">
                            <v-btn
                                size="small"
                                color="success"
                                variant="outlined"
                                @click="approveReservation(item.id)"
                            >
                                {{ __('Approve') }}
                            </v-btn>
                            <v-btn
                                size="small"
                                color="error"
                                variant="outlined"
                                @click="rejectReservation(item.id)"
                            >
                                {{ __('Reject') }}
                            </v-btn>
                        </div>
                    </template>
                </x-data-table>

                <div v-else class="text-center py-8">
                    <v-icon size="64" color="grey-lighten-2">mdi-calendar-check</v-icon>
                    <div class="text-h6 text-grey mt-2">{{ __('No pending reservations') }}</div>
                    <div class="text-body-2 text-grey">{{ __('All reservations are up to date') }}</div>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Maintenance Alerts -->
<v-row class="mb-6">
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title class="d-flex align-center">
                <v-icon class="me-2" color="warning">mdi-alert</v-icon>
                {{ __('Maintenance Alerts') }}
            </v-card-title>
            <v-card-text>
                <v-list v-if="maintenanceAlerts.length > 0">
                    <v-list-item
                        v-for="alert in maintenanceAlerts"
                        :key="alert.id"
                        class="mb-2"
                    >
                        <template v-slot:prepend>
                            <v-avatar :color="alert.priority" size="32">
                                <v-icon color="white" size="small">mdi-wrench</v-icon>
                            </v-avatar>
                        </template>
                        <v-list-item-title>@{{ alert.equipment_name }}</v-list-item-title>
                        <v-list-item-subtitle>
                            @{{ alert.message }} • {{ __('Due') }}: @{{ formatDate(alert.due_date) }}
                        </v-list-item-subtitle>
                        <template v-slot:append>
                            <v-btn
                                size="small"
                                variant="outlined"
                                @click="scheduleMaintenance(alert.equipment_id)"
                            >
                                {{ __('Schedule') }}
                            </v-btn>
                        </template>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-4">
                    <v-icon color="success" size="48">mdi-check-circle</v-icon>
                    <div class="text-body-2 text-grey mt-2">{{ __('All equipment up to date') }}</div>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <!-- Recent Activities -->
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Recent Lab Activities') }}</v-card-title>
            <v-card-text>
                <v-list density="compact">
                    <v-list-item
                        v-for="activity in labActivities"
                        :key="activity.id"
                    >
                        <template v-slot:prepend>
                            <v-avatar size="32" :color="getActivityColor(activity.type)">
                                <v-icon color="white" size="small">
                                    @{{ getActivityIcon(activity.type) }}
                                </v-icon>
                            </v-avatar>
                        </template>
                        <v-list-item-title>@{{ activity.description }}</v-list-item-title>
                        <v-list-item-subtitle>
                            @{{ activity.user_name }} • @{{ formatDateTime(activity.created_at) }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<script>
// Lab Manager-specific dashboard methods
Object.assign(dashboardApp.methods, {
    async approveReservation(reservationId) {
        try {
            await axios.put(`/api/v1/reservations/${reservationId}/approve`);
            this.refreshData();
            this.$refs.snackbar.show({
                message: '{{ __("Reservation approved successfully") }}',
                type: 'success'
            });
        } catch (error) {
            console.error('Approval failed:', error);
        }
    },

    async rejectReservation(reservationId) {
        try {
            await axios.put(`/api/v1/reservations/${reservationId}/reject`);
            this.refreshData();
            this.$refs.snackbar.show({
                message: '{{ __("Reservation rejected") }}',
                type: 'info'
            });
        } catch (error) {
            console.error('Rejection failed:', error);
        }
    },

    async scheduleMaintenance(equipmentId) {
        // Open maintenance scheduling dialog
        console.log('Schedule maintenance for equipment:', equipmentId);
    },

    async generateReport() {
        try {
            const response = await axios.get('/api/v1/lab-manager/reports/equipment-usage', {
                responseType: 'blob'
            });

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `equipment-usage-report-${new Date().toISOString().split('T')[0]}.pdf`);
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error('Report generation failed:', error);
        }
    },

    formatTime(datetime) {
        return new Date(datetime).toLocaleTimeString('{{ app()->getLocale() }}', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});

// Lab Manager dashboard data
Object.assign(dashboardApp.data(), {
    reservationHeaders: [
        { title: '{{ __("Equipment") }}', key: 'equipment.name', sortable: false },
        { title: '{{ __("Researcher") }}', key: 'researcher.full_name', sortable: false },
        { title: '{{ __("Date & Time") }}', key: 'start_datetime', sortable: true },
        { title: '{{ __("Purpose") }}', key: 'purpose', sortable: false },
        { title: '{{ __("Actions") }}', key: 'actions', sortable: false, align: 'center' }
    ],
    equipmentStats: [
        { label: '{{ __("Average Usage") }}', value: 78, unit: '%', color: 'primary' },
        { label: '{{ __("Peak Hours") }}', value: '9-17', unit: '', color: 'warning' },
        { label: '{{ __("Downtime") }}', value: 2.5, unit: '%', color: 'error' },
        { label: '{{ __("Efficiency") }}', value: 94, unit: '%', color: 'success' }
    ],
    maintenanceAlerts: [
        {
            id: 1,
            equipment_name: 'High-Performance Computer',
            message: 'Scheduled maintenance due',
            due_date: '2024-12-25',
            priority: 'warning',
            equipment_id: 1
        },
        {
            id: 2,
            equipment_name: 'Microscope',
            message: 'Calibration required',
            due_date: '2024-12-30',
            priority: 'error',
            equipment_id: 2
        }
    ],
    labActivities: [
        {
            id: 1,
            type: 'reservation_approved',
            description: 'Equipment reservation approved',
            user_name: 'Dr. Ahmed Mohamed',
            created_at: new Date().toISOString()
        },
        {
            id: 2,
            type: 'equipment_added',
            description: 'New equipment added to inventory',
            user_name: 'Lab Manager',
            created_at: new Date(Date.now() - 3600000).toISOString()
        }
    ]
});
</script>