<!-- Visitor Dashboard -->
<v-row class="mb-6">
    <!-- Public Information Stats -->
    <v-col cols="12" sm="6" md="3">
        <v-card color="primary" variant="flat">
            <v-card-text class="text-white">
                <div class="d-flex align-center">
                    <div class="flex-grow-1">
                        <div class="text-h4 font-weight-bold">
                            @{{ dashboardData.public_info?.total_researchers || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Researchers') }}</div>
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
                            @{{ dashboardData.public_info?.total_publications || 0 }}
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
                            @{{ dashboardData.public_info?.active_collaborations || 0 }}
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
                            @{{ dashboardData.public_info?.upcoming_events || 0 }}
                        </div>
                        <div class="text-subtitle-1">{{ __('Upcoming Events') }}</div>
                    </div>
                    <v-icon size="48" class="opacity-75">mdi-calendar</v-icon>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Welcome Section -->
<v-row class="mb-6">
    <v-col cols="12">
        <v-card class="bg-gradient-to-r from-blue-500 to-purple-600" variant="flat">
            <v-card-text class="text-white pa-8">
                <div class="text-center">
                    <v-avatar size="80" class="mb-4">
                        <v-img
                            src="/images/sglr-logo.png"
                            alt="SGLR Logo"
                        ></v-img>
                    </v-avatar>
                    <h2 class="text-h4 font-weight-bold mb-2">
                        {{ __('Welcome to SGLR') }}
                    </h2>
                    <p class="text-h6 opacity-90 mb-4">
                        {{ __('Scientific Research Laboratory Management System') }}
                    </p>
                    <p class="text-body-1 opacity-80 max-w-2xl mx-auto">
                        {{ __('Explore our research activities, publications, and collaborate with our researchers. Join our events and stay updated with the latest scientific developments.') }}
                    </p>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Quick Links -->
<v-row class="mb-6">
    <v-col cols="12">
        <v-card>
            <v-card-title>{{ __('Quick Access') }}</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="6" md="3">
                        <v-card
                            variant="outlined"
                            hover
                            :to="{ name: 'researchers.index' }"
                            class="text-center pa-4"
                        >
                            <v-icon size="48" color="primary" class="mb-2">mdi-account-group</v-icon>
                            <div class="text-h6 font-weight-medium">{{ __('Browse Researchers') }}</div>
                            <div class="text-body-2 text-grey">{{ __('Discover our research team') }}</div>
                        </v-card>
                    </v-col>

                    <v-col cols="12" sm="6" md="3">
                        <v-card
                            variant="outlined"
                            hover
                            :to="{ name: 'publications.index' }"
                            class="text-center pa-4"
                        >
                            <v-icon size="48" color="success" class="mb-2">mdi-book-open-variant</v-icon>
                            <div class="text-h6 font-weight-medium">{{ __('Publications') }}</div>
                            <div class="text-body-2 text-grey">{{ __('Explore research outputs') }}</div>
                        </v-card>
                    </v-col>

                    <v-col cols="12" sm="6" md="3">
                        <v-card
                            variant="outlined"
                            hover
                            :to="{ name: 'events.index' }"
                            class="text-center pa-4"
                        >
                            <v-icon size="48" color="warning" class="mb-2">mdi-calendar</v-icon>
                            <div class="text-h6 font-weight-medium">{{ __('Events') }}</div>
                            <div class="text-body-2 text-grey">{{ __('Join our activities') }}</div>
                        </v-card>
                    </v-col>

                    <v-col cols="12" sm="6" md="3">
                        <v-card
                            variant="outlined"
                            hover
                            :to="{ name: 'collaborations.index' }"
                            class="text-center pa-4"
                        >
                            <v-icon size="48" color="info" class="mb-2">mdi-handshake</v-icon>
                            <div class="text-h6 font-weight-medium">{{ __('Collaborations') }}</div>
                            <div class="text-body-2 text-grey">{{ __('Partnership opportunities') }}</div>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Recent Publications -->
<v-row class="mb-6">
    <v-col cols="12" md="8">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>{{ __('Recent Publications') }}</span>
                <v-btn
                    size="small"
                    variant="text"
                    :to="{ name: 'publications.index' }"
                >
                    {{ __('View All') }}
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-list v-if="dashboardData.recent_publications?.length > 0">
                    <v-list-item
                        v-for="publication in dashboardData.recent_publications"
                        :key="publication.id"
                        :to="{ name: 'publications.show', params: { publication: publication.id } }"
                        class="mb-2"
                    >
                        <template v-slot:prepend>
                            <v-avatar color="success" size="40">
                                <v-icon color="white">mdi-book</v-icon>
                            </v-avatar>
                        </template>

                        <v-list-item-title class="font-weight-medium">
                            @{{ publication.title }}
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            <div class="d-flex align-center mt-1">
                                <span>@{{ publication.authors?.slice(0, 3).join(', ') }}</span>
                                <span v-if="publication.authors?.length > 3" class="ml-1">
                                    {{ __('et al.') }}
                                </span>
                                <v-chip
                                    size="x-small"
                                    variant="outlined"
                                    class="ml-2"
                                >
                                    @{{ publication.publication_year }}
                                </v-chip>
                            </div>
                            <div class="text-caption text-grey mt-1">
                                @{{ publication.journal }}
                            </div>
                        </v-list-item-subtitle>

                        <template v-slot:append>
                            <div class="text-end">
                                <v-chip
                                    :color="getStatusColor(publication.type)"
                                    size="x-small"
                                    variant="flat"
                                >
                                    <template v-slot:prepend>
                                        <v-icon size="small">@{{ getStatusIcon(publication.type) }}</v-icon>
                                    </template>
                                    @{{ getStatusText(publication.type) }}
                                </v-chip>
                                <div v-if="publication.doi" class="text-caption text-grey mt-1">
                                    DOI: @{{ publication.doi.substring(0, 20) }}...
                                </div>
                            </div>
                        </template>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-8">
                    <v-icon size="64" color="grey-lighten-2">mdi-book-outline</v-icon>
                    <div class="text-h6 text-grey mt-2">{{ __('No publications available') }}</div>
                </div>
            </v-card-text>
        </v-card>
    </v-col>

    <!-- Research Domains -->
    <v-col cols="12" md="4">
        <v-card>
            <v-card-title>{{ __('Research Domains') }}</v-card-title>
            <v-card-text>
                <v-list density="compact" v-if="dashboardData.research_domains?.length > 0">
                    <v-list-item
                        v-for="domain in dashboardData.research_domains"
                        :key="domain.research_domain"
                    >
                        <template v-slot:prepend>
                            <v-icon color="primary">mdi-flask</v-icon>
                        </template>
                        <v-list-item-title>@{{ domain.research_domain }}</v-list-item-title>
                        <template v-slot:append>
                            <v-chip size="small" variant="outlined">
                                @{{ domain.count }} {{ __('researchers') }}
                            </v-chip>
                        </template>
                    </v-list-item>
                </v-list>
                <div v-else class="text-center py-4">
                    <v-icon color="grey-lighten-2">mdi-domain</v-icon>
                    <div class="text-body-2 text-grey">{{ __('No domains available') }}</div>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Upcoming Events -->
<v-row class="mb-6">
    <v-col cols="12">
        <v-card>
            <v-card-title class="d-flex align-center justify-space-between">
                <span>{{ __('Upcoming Events') }}</span>
                <v-btn
                    size="small"
                    variant="text"
                    :to="{ name: 'events.index' }"
                >
                    {{ __('View All') }}
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-row v-if="dashboardData.upcoming_events?.length > 0">
                    <v-col
                        v-for="event in dashboardData.upcoming_events"
                        :key="event.id"
                        cols="12"
                        md="4"
                    >
                        <v-card variant="outlined" hover>
                            <v-card-text>
                                <div class="d-flex align-start">
                                    <v-avatar color="warning" size="40" class="me-3">
                                        <v-icon color="white">mdi-calendar</v-icon>
                                    </v-avatar>
                                    <div class="flex-grow-1">
                                        <div class="font-weight-medium">@{{ event.title }}</div>
                                        <div class="text-body-2 text-grey mt-1">
                                            @{{ formatDate(event.start_date) }}
                                        </div>
                                        <div class="text-caption text-grey">
                                            @{{ event.location }}
                                        </div>
                                        <v-chip
                                            :color="getStatusColor(event.type)"
                                            size="x-small"
                                            variant="flat"
                                            class="mt-2"
                                        >
                                            <template v-slot:prepend>
                                                <v-icon size="small">@{{ getStatusIcon(event.type) }}</v-icon>
                                            </template>
                                            @{{ getStatusText(event.type) }}
                                        </v-chip>
                                    </div>
                                </div>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    size="small"
                                    color="primary"
                                    variant="outlined"
                                    :to="{ name: 'events.show', params: { event: event.id } }"
                                >
                                    {{ __('Learn More') }}
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
                <div v-else class="text-center py-8">
                    <v-icon size="64" color="grey-lighten-2">mdi-calendar-outline</v-icon>
                    <div class="text-h6 text-grey mt-2">{{ __('No upcoming events') }}</div>
                    <div class="text-body-2 text-grey">{{ __('Check back later for new events') }}</div>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<!-- Contact Information -->
<v-row>
    <v-col cols="12">
        <v-card color="grey-lighten-5" variant="flat">
            <v-card-text class="text-center pa-8">
                <v-icon size="48" color="primary" class="mb-4">mdi-email</v-icon>
                <h3 class="text-h5 font-weight-bold mb-2">{{ __('Get in Touch') }}</h3>
                <p class="text-body-1 text-grey-darken-1 mb-4">
                    {{ __('Interested in collaborating or learning more about our research?') }}
                </p>
                <div class="d-flex justify-center ga-4 flex-wrap">
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-email"
                        href="mailto:contact@sglr.com"
                    >
                        {{ __('Contact Us') }}
                    </v-btn>
                    <v-btn
                        color="success"
                        prepend-icon="mdi-account-plus"
                        href="/register"
                    >
                        {{ __('Join as Researcher') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>

<script>
// Visitor-specific dashboard methods
Object.assign(dashboardApp.methods, {
    formatDate(date) {
        return new Date(date).toLocaleDateString('{{ app()->getLocale() }}', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
});
</script>