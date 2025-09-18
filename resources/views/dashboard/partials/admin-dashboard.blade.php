<!-- Admin Dashboard -->
<v-row class="mb-6">
    <!-- Overview Stats -->
    <v-col cols="12" sm="6" md="3">
        <v-card color="primary" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.total_users || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Total Users') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-account-group</v-icon>
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
                            @{{ dashboardData.overview?.active_projects || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Active Projects') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-folder-multiple</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" sm="6" md="3">
        <v-card color="info" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.total_publications || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Publications') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-book-open-variant</v-icon>
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
                            @{{ dashboardData.overview?.equipment_utilization || 0 }}%
                        </div>
                        <div class="text-subtitle-1">{{ __('Equipment Usage') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-tools</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Charts Section -->
<v-row class="mb-6">
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Projects by Status') }}</v-card-title>
            <v-card-text>
                <div ref="projectsChart" style="height: 300px;"></div>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Publications by Year') }}</v-card-title>
            <v-card-text>
                <div ref="publicationsChart" style="height: 300px;"></div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Recent Activity Tables -->
<v-row class="mb-6">
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>{{ __('Recent Users') }}</span>
                <v-btn
                    size="small"
                    variant="text"
                    :to="{ name: 'admin.users' }"
                >
                    {{ __('View All') }}
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-list density="compact">
                    <v-list-item
                        v-for="user in dashboardData.recent_activity?.new_users || []"
                        :key="user.id"
                        :to="{ name: 'admin.users.show', params: { user: user.id } }"
                    >
                        <template v-slot:prepend>
                            <v-avatar size="32">
                                <v-img
                                    :src="user.photo_url || '/images/default-avatar.png'"
                                    :alt="user.name"
                                ></v-img>
                            </v-avatar>
                        </template>
                        <v-list-item-title>@{{ user.name }}</v-list-item-title>
                        <v-list-item-subtitle>
                            @{{ user.email }} • @{{ user.role }}
                        </v-list-item-subtitle>
                        <template v-slot:append>
                            <x-status-chip :status="user.role" size="x-small" />
                        </template>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-col>

    <v-col cols="12" md="6">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>{{ __('Recent Projects') }}</span>
                <v-btn
                    size="small"
                    variant="text"
                    :to="{ name: 'projects.index' }"
                >
                    {{ __('View All') }}
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-list density="compact">
                    <v-list-item
                        v-for="project in dashboardData.recent_activity?.recent_projects || []"
                        :key="project.id"
                        :to="{ name: 'projects.show', params: { project: project.id } }"
                    >
                        <template v-slot:prepend>
                            <v-avatar color="primary" size="32">
                                <v-icon color="white" size="small">mdi-folder</v-icon>
                            </v-avatar>
                        </template>
                        <v-list-item-title>@{{ project.title }}</v-list-item-title>
                        <v-list-item-subtitle>
                            {{ __('Leader') }}: @{{ project.leader?.full_name }}
                        </v-list-item-subtitle>
                        <template v-slot:append>
                            <x-status-chip :status="project.status" size="x-small" />
                        </template>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- System Health -->
<v-row class="mb-6">
    <v-col cols="12">
        <v-card>
            <v-card-title class="d-flex align-center">
                <v-icon class="me-2">mdi-heart-pulse</v-icon>
                {{ __('System Health') }}
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="3">
                        <div class="text-center">
                            <v-progress-circular
                                :model-value="systemHealth.server_load || 0"
                                size="80"
                                width="8"
                                color="primary"
                            >
                                @{{ systemHealth.server_load || 0 }}%
                            </v-progress-circular>
                            <div class="text-subtitle-2 mt-2">{{ __('Server Load') }}</div>
                        </div>
                    </v-col>
                    <v-col cols="12" md="3">
                        <div class="text-center">
                            <v-progress-circular
                                :model-value="systemHealth.memory_usage || 0"
                                size="80"
                                width="8"
                                color="success"
                            >
                                @{{ systemHealth.memory_usage || 0 }}%
                            </v-progress-circular>
                            <div class="text-subtitle-2 mt-2">{{ __('Memory Usage') }}</div>
                        </div>
                    </v-col>
                    <v-col cols="12" md="3">
                        <div class="text-center">
                            <v-progress-circular
                                :model-value="systemHealth.disk_usage || 0"
                                size="80"
                                width="8"
                                color="warning"
                            >
                                @{{ systemHealth.disk_usage || 0 }}%
                            </v-progress-circular>
                            <div class="text-subtitle-2 mt-2">{{ __('Disk Usage') }}</div>
                        </div>
                    </v-col>
                    <v-col cols="12" md="3">
                        <div class="text-center">
                            <v-progress-circular
                                :model-value="systemHealth.database_connections || 0"
                                size="80"
                                width="8"
                                color="info"
                            >
                                @{{ systemHealth.database_connections || 0 }}%
                            </v-progress-circular>
                            <div class="text-subtitle-2 mt-2">{{ __('DB Connections') }}</div>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Quick Actions -->
<v-row>
    <v-col cols="12">
        <v-card>
            <v-card-title>{{ __('Quick Actions') }}</v-card-title>
            <v-card-text>
                <div class="d-flex flex-wrap ga-4">
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-account-plus"
                        :to="{ name: 'admin.users.create' }"
                    >
                        {{ __('Add User') }}
                    </v-btn>

                    <v-btn
                        color="success"
                        prepend-icon="mdi-database-export"
                        @click="exportData"
                    >
                        {{ __('Export Data') }}
                    </v-btn>

                    <v-btn
                        color="warning"
                        prepend-icon="mdi-database"
                        @click="runBackup"
                    >
                        {{ __('Backup System') }}
                    </v-btn>

                    <v-btn
                        color="info"
                        prepend-icon="mdi-chart-line"
                        :to="{ name: 'admin.analytics' }"
                    >
                        {{ __('View Analytics') }}
                    </v-btn>

                    <v-btn
                        color="purple"
                        prepend-icon="mdi-cog"
                        :to="{ name: 'admin.settings' }"
                    >
                        {{ __('System Settings') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<script>
// Admin-specific dashboard methods
Object.assign(dashboardApp.methods, {
    async exportData() {
        try {
            const response = await axios.post('/api/v1/admin/export-data', {
                format: 'excel',
                tables: ['users', 'projects', 'publications', 'equipment']
            }, {
                responseType: 'blob'
            });

            // Create download
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `sglr-data-export-${new Date().toISOString().split('T')[0]}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error('Export failed:', error);
        }
    },

    async runBackup() {
        try {
            await axios.post('/api/v1/admin/backup');
            this.$refs.snackbar.show({
                message: '{{ __("Backup started successfully") }}',
                type: 'success'
            });
        } catch (error) {
            console.error('Backup failed:', error);
            this.$refs.snackbar.show({
                message: '{{ __("Backup failed") }}',
                type: 'error'
            });
        }
    }
});

// Admin dashboard data
Object.assign(dashboardApp.data(), {
    systemHealth: {
        server_load: 45,
        memory_usage: 67,
        disk_usage: 23,
        database_connections: 34
    }
});
</script>