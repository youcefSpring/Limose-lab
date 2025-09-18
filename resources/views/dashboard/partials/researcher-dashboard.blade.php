<!-- Researcher Dashboard -->
<v-row class="mb-6">
    <!-- Personal Stats -->
    <v-col cols="12" sm="6" md="3">
        <v-card color="primary" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.total_projects || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('My Projects') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-folder-multiple</v-icon>
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
        <v-card color="info" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.overview?.total_collaborations || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Collaborations') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-handshake</v-icon>
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
                            @{{ dashboardData.overview?.equipment_reservations || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Reservations') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-calendar-clock</v-icon>
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
                        prepend-icon="mdi-folder-plus"
                        :to="{ name: 'projects.create' }"
                    >
                        {{ __('New Project') }}
                    </v-btn>

                    <v-btn
                        color="success"
                        prepend-icon="mdi-book-plus"
                        :to="{ name: 'publications.create' }"
                    >
                        {{ __('Add Publication') }}
                    </v-btn>

                    <v-btn
                        color="info"
                        prepend-icon="mdi-calendar-plus"
                        :to="{ name: 'equipment.reservations' }"
                    >
                        {{ __('Reserve Equipment') }}
                    </v-btn>

                    <v-btn
                        color="purple"
                        prepend-icon="mdi-handshake"
                        :to="{ name: 'collaborations.create' }"
                    >
                        {{ __('Start Collaboration') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Active Projects -->
<v-row class="mb-6">
    <v-col cols="12" md="8">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>{{ __('My Active Projects') }}</span>
                <v-btn
                    size="small"
                    variant="text"
                    :to="{ name: 'projects.index' }"
                >
                    {{ __('View All') }}
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-list v-if="dashboardData.my_projects?.length > 0">
                    <v-list-item
                        v-for="project in dashboardData.my_projects"
                        :key="project.id"
                        :to="{ name: 'projects.show', params: { project: project.id } }"
                        class="mb-2"
                    >
                        <template v-slot:prepend>
                            <v-avatar color="primary" size="40">
                                <v-icon color="white">mdi-folder</v-icon>
                            </v-avatar>
                        </template>

                        <v-list-item-title>@{{ project.title }}</v-list-item-title>
                        <v-list-item-subtitle>
                            {{ __('Members') }}: @{{ project.members?.length || 0 }} •
                            {{ __('Budget') }}: @{{ formatCurrency(project.budget) }}
                        </v-list-item-subtitle>

                        <template v-slot:append>
                            <div class="text-end">
                                <x-status-chip :status="project.status" size="small" />
                                <div class="text-caption text-grey mt-1">
                                    @{{ formatDate(project.start_date) }}
                                </div>
                            </div>
                        </template>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-8">
                    <v-icon size="64" color="grey-lighten-2">mdi-folder-outline</v-icon>
                    <div class="text-h6 text-grey mt-2">{{ __('No active projects') }}</div>
                    <v-btn
                        color="primary"
                        variant="outlined"
                        class="mt-4"
                        :to="{ name: 'projects.create' }"
                    >
                        {{ __('Create Your First Project') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <!-- Upcoming Events & Reservations -->
    <v-col cols="12" md="4">
        <v-card class="mb-4">
            <v-card-title>{{ __('Upcoming Reservations') }}</v-card-title>
            <v-card-text>
                <v-list density="compact" v-if="dashboardData.upcoming_reservations?.length > 0">
                    <v-list-item
                        v-for="reservation in dashboardData.upcoming_reservations"
                        :key="reservation.id"
                    >
                        <template v-slot:prepend>
                            <v-icon color="warning">mdi-tools</v-icon>
                        </template>
                        <v-list-item-title>@{{ reservation.equipment.name }}</v-list-item-title>
                        <v-list-item-subtitle>
                            @{{ formatDateTime(reservation.start_datetime) }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-4">
                    <v-icon color="grey-lighten-2">mdi-calendar</v-icon>
                    <div class="text-body-2 text-grey">{{ __('No upcoming reservations') }}</div>
                </div>
            </v-card-text>
        </v-card>

        <v-card>
            <v-card-title>{{ __('Upcoming Events') }}</v-card-title>
            <v-card-text>
                <v-list density="compact" v-if="dashboardData.upcoming_events?.length > 0">
                    <v-list-item
                        v-for="event in dashboardData.upcoming_events"
                        :key="event.id"
                        :to="{ name: 'events.show', params: { event: event.id } }"
                    >
                        <template v-slot:prepend>
                            <v-icon color="purple">mdi-calendar-star</v-icon>
                        </template>
                        <v-list-item-title>@{{ event.title }}</v-list-item-title>
                        <v-list-item-subtitle>
                            @{{ formatDate(event.start_date) }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-4">
                    <v-icon color="grey-lighten-2">mdi-calendar-outline</v-icon>
                    <div class="text-body-2 text-grey">{{ __('No upcoming events') }}</div>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Publications & Research Progress -->
<v-row class="mb-6">
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Recent Publications') }}</v-card-title>
            <v-card-text>
                <v-list v-if="dashboardData.recent_publications?.length > 0">
                    <v-list-item
                        v-for="publication in dashboardData.recent_publications"
                        :key="publication.id"
                        :to="{ name: 'publications.show', params: { publication: publication.id } }"
                    >
                        <template v-slot:prepend>
                            <v-avatar color="success" size="32">
                                <v-icon color="white" size="small">mdi-book</v-icon>
                            </v-avatar>
                        </template>
                        <v-list-item-title>@{{ publication.title }}</v-list-item-title>
                        <v-list-item-subtitle>
                            @{{ publication.journal }} • @{{ publication.publication_year }}
                        </v-list-item-subtitle>
                        <template v-slot:append>
                            <x-status-chip :status="publication.type" size="x-small" />
                        </template>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-4">
                    <v-icon size="48" color="grey-lighten-2">mdi-book-outline</v-icon>
                    <div class="text-body-2 text-grey mt-2">{{ __('No publications yet') }}</div>
                    <v-btn
                        color="success"
                        variant="outlined"
                        size="small"
                        class="mt-2"
                        :to="{ name: 'publications.create' }"
                    >
                        {{ __('Add Publication') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <!-- Research Metrics -->
    <v-col cols="12" md="6">
        <v-card>
            <v-card-title>{{ __('Research Metrics') }}</v-card-title>
            <v-card-text>
                <div class="text-center mb-4">
                    <v-progress-circular
                        :model-value="researcherMetrics.h_index || 0"
                        size="100"
                        width="8"
                        color="primary"
                    >
                        <div class="text-h6">@{{ researcherMetrics.h_index || 0 }}</div>
                        <div class="text-caption">H-Index</div>
                    </v-progress-circular>
                </div>

                <v-row>
                    <v-col cols="6">
                        <div class="text-center">
                            <div class="text-h6 font-weight-bold">
                                @{{ researcherMetrics.total_citations || 0 }}
                            </div>
                            <div class="text-caption text-grey">{{ __('Citations') }}</div>
                        </div>
                    </v-col>
                    <v-col cols="6">
                        <div class="text-center">
                            <div class="text-h6 font-weight-bold">
                                @{{ researcherMetrics.publication_years || 0 }}
                            </div>
                            <div class="text-caption text-grey">{{ __('Active Years') }}</div>
                        </div>
                    </v-col>
                </v-row>

                <v-divider class="my-4"></v-divider>

                <div class="d-flex justify-space-between align-center">
                    <span class="text-body-2">{{ __('ORCID Profile') }}</span>
                    <v-btn
                        v-if="user.researcher?.orcid_id"
                        size="small"
                        variant="outlined"
                        :href="`https://orcid.org/${user.researcher.orcid_id}`"
                        target="_blank"
                    >
                        {{ __('View') }}
                    </v-btn>
                    <v-btn
                        v-else
                        size="small"
                        variant="outlined"
                        :to="{ name: 'dashboard.profile' }"
                    >
                        {{ __('Add ORCID') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<script>
// Researcher-specific dashboard methods
Object.assign(dashboardApp.methods, {
    formatCurrency(amount) {
        return new Intl.NumberFormat('{{ app()->getLocale() }}', {
            style: 'currency',
            currency: 'USD'
        }).format(amount || 0);
    },

    formatDate(date) {
        return new Date(date).toLocaleDateString('{{ app()->getLocale() }}');
    },

    formatDateTime(dateTime) {
        return new Date(dateTime).toLocaleString('{{ app()->getLocale() }}');
    }
});

// Researcher dashboard data
Object.assign(dashboardApp.data(), {
    researcherMetrics: {
        h_index: 12,
        total_citations: 145,
        publication_years: 5
    }
});
</script>