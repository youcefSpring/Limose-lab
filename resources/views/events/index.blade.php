@extends('layouts.app', ['title' => __('Events Management')])

@section('content')
<div id="events-app">
    <div class="d-flex justify-space-between align-center mb-6">
        <div>
            <h2 class="text-h4 font-weight-bold">{{ __('Events Management') }}</h2>
            <p class="text-body-1 text-grey">{{ __('Manage scientific events, conferences, and workshops') }}</p>
        </div>
        @can('create', App\Models\Event::class)
        <v-btn
            color="primary"
            prepend-icon="mdi-plus"
            href="{{ route('events.create') }}"
        >
            {{ __('Create Event') }}
        </v-btn>
        @endcan
    </div>

    <!-- Filters -->
    <v-card class="mb-6" variant="outlined">
        <v-card-text>
            <v-row>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="filters.search"
                        :label="'{{ __('Search events...') }}'"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        density="compact"
                        hide-details
                        clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-select
                        v-model="filters.type"
                        :items="eventTypes"
                        :label="'{{ __('Event Type') }}'"
                        variant="outlined"
                        density="compact"
                        hide-details
                        clearable
                    ></v-select>
                </v-col>
                <v-col cols="12" md="3">
                    <v-select
                        v-model="filters.status"
                        :items="statusOptions"
                        :label="'{{ __('Status') }}'"
                        variant="outlined"
                        density="compact"
                        hide-details
                        clearable
                    ></v-select>
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="filters.date"
                        :label="'{{ __('Date') }}'"
                        type="date"
                        variant="outlined"
                        density="compact"
                        hide-details
                        clearable
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>

    <!-- View Toggle -->
    <div class="d-flex justify-end mb-4">
        <v-btn-toggle v-model="viewMode" mandatory>
            <v-btn value="list" icon="mdi-view-list"></v-btn>
            <v-btn value="calendar" icon="mdi-calendar-month"></v-btn>
        </v-btn-toggle>
    </div>

    <!-- List View -->
    <div v-if="viewMode === 'list'">
        <v-card>
            <v-data-table
                :headers="headers"
                :items="events"
                :loading="loading"
                :search="filters.search"
                item-value="id"
                class="elevation-0"
            >
                <!-- Event Title Column -->
                <template #item.title="{ item }">
                    <div class="d-flex align-center">
                        <v-avatar class="mr-3" size="40" :color="getEventTypeColor(item.type)">
                            <v-icon>@{{ getEventTypeIcon(item.type) }}</v-icon>
                        </v-avatar>
                        <div>
                            <div class="font-weight-medium">@{{ item.title }}</div>
                            <div class="text-caption text-grey">@{{ item.organizer }}</div>
                        </div>
                    </div>
                </template>

                <!-- Type Column -->
                <template #item.type="{ item }">
                    <v-chip
                        :color="getEventTypeColor(item.type)"
                        variant="tonal"
                        size="small"
                    >
                        @{{ getEventTypeText(item.type) }}
                    </v-chip>
                </template>

                <!-- Date Column -->
                <template #item.start_date="{ item }">
                    <div>
                        <div class="text-body-2">@{{ formatDate(item.start_date) }}</div>
                        <div class="text-caption text-grey">@{{ formatTime(item.start_date) }}</div>
                    </div>
                </template>

                <!-- Location Column -->
                <template #item.location="{ item }">
                    <div class="d-flex align-center">
                        <v-icon size="16" class="mr-1">
                            @{{ item.is_virtual ? 'mdi-video' : 'mdi-map-marker' }}
                        </v-icon>
                        <span class="text-body-2">@{{ item.location || 'Virtual' }}</span>
                    </div>
                </template>

                <!-- Status Column -->
                <template #item.status="{ item }">
                    <v-chip
                        :color="getStatusColor(item.status)"
                        variant="tonal"
                        size="small"
                    >
                        <v-icon start size="16">@{{ getStatusIcon(item.status) }}</v-icon>
                        @{{ getStatusText(item.status) }}
                    </v-chip>
                </template>

                <!-- Registrations Column -->
                <template #item.registrations_count="{ item }">
                    <div class="text-center">
                        <div class="font-weight-medium">@{{ item.registrations_count || 0 }}</div>
                        <div class="text-caption text-grey">
                            / @{{ item.max_participants || '∞' }}
                        </div>
                    </div>
                </template>

                <!-- Actions Column -->
                <template #item.actions="{ item }">
                    <div class="d-flex ga-2">
                        <v-btn
                            icon="mdi-eye"
                            size="small"
                            variant="text"
                            :href="`/events/${item.id}`"
                        ></v-btn>

                        @can('update', App\Models\Event::class)
                        <v-btn
                            icon="mdi-pencil"
                            size="small"
                            variant="text"
                            :href="`/events/${item.id}/edit`"
                        ></v-btn>
                        @endcan

                        @can('delete', App\Models\Event::class)
                        <v-btn
                            icon="mdi-delete"
                            size="small"
                            variant="text"
                            color="error"
                            @click="confirmDelete(item)"
                        ></v-btn>
                        @endcan

                        <v-btn
                            icon="mdi-account-plus"
                            size="small"
                            variant="text"
                            color="primary"
                            @click="openRegistrationDialog(item)"
                            :disabled="!canRegister(item)"
                        ></v-btn>
                    </div>
                </template>
            </v-data-table>
        </v-card>
    </div>

    <!-- Calendar View -->
    <div v-if="viewMode === 'calendar'">
        <v-card>
            <v-card-text>
                <div id="calendar"></div>
            </v-card-text>
        </v-card>
    </div>

    <!-- Registration Dialog -->
    <v-dialog v-model="registrationDialog" max-width="600">
        <v-card>
            <v-card-title>
                <span class="text-h5">{{ __('Event Registration') }}</span>
            </v-card-title>
            <v-card-text>
                <div v-if="selectedEvent">
                    <div class="d-flex align-center mb-4">
                        <v-avatar :color="getEventTypeColor(selectedEvent.type)" class="mr-3">
                            <v-icon>@{{ getEventTypeIcon(selectedEvent.type) }}</v-icon>
                        </v-avatar>
                        <div>
                            <div class="font-weight-medium">@{{ selectedEvent.title }}</div>
                            <div class="text-caption text-grey">@{{ selectedEvent.organizer }}</div>
                        </div>
                    </div>

                    <v-row>
                        <v-col cols="12" md="6">
                            <div class="text-caption text-grey">{{ __('Date & Time') }}</div>
                            <div class="text-body-1">@{{ formatDateTime(selectedEvent.start_date) }}</div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="text-caption text-grey">{{ __('Location') }}</div>
                            <div class="text-body-1">@{{ selectedEvent.location || 'Virtual' }}</div>
                        </v-col>
                    </v-row>

                    <v-form ref="registrationForm" class="mt-4">
                        <v-textarea
                            v-model="registrationForm.notes"
                            :label="'{{ __('Additional Notes (Optional)') }}'"
                            variant="outlined"
                            rows="3"
                            :hint="'{{ __('Any special requirements or questions') }}'"
                            persistent-hint
                        ></v-textarea>
                    </v-form>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="registrationDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="primary" @click="submitRegistration" :loading="registrationLoading">
                    {{ __('Register') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="deleteDialog" max-width="400">
        <v-card>
            <v-card-title class="text-h5">{{ __('Confirm Delete') }}</v-card-title>
            <v-card-text>
                {{ __('Are you sure you want to delete this event? This action cannot be undone.') }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="deleteDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="error" @click="deleteEvent" :loading="deleteLoading">
                    {{ __('Delete') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
@endsection

@push('scripts')
<script>
const eventsApp = createApp({
    data() {
        return {
            loading: false,
            events: [],
            viewMode: 'list',
            filters: {
                search: '',
                type: null,
                status: null,
                date: null
            },
            headers: [
                { title: '{{ __("Event") }}', key: 'title', sortable: true },
                { title: '{{ __("Type") }}', key: 'type', sortable: true },
                { title: '{{ __("Date") }}', key: 'start_date', sortable: true },
                { title: '{{ __("Location") }}', key: 'location', sortable: true },
                { title: '{{ __("Status") }}', key: 'status', sortable: true },
                { title: '{{ __("Registrations") }}', key: 'registrations_count', sortable: true },
                { title: '{{ __("Actions") }}', key: 'actions', sortable: false, width: 200 }
            ],
            eventTypes: [
                { title: '{{ __("Conference") }}', value: 'conference' },
                { title: '{{ __("Workshop") }}', value: 'workshop' },
                { title: '{{ __("Seminar") }}', value: 'seminar' },
                { title: '{{ __("Training") }}', value: 'training' },
                { title: '{{ __("Meeting") }}', value: 'meeting' }
            ],
            statusOptions: [
                { title: '{{ __("Draft") }}', value: 'draft' },
                { title: '{{ __("Published") }}', value: 'published' },
                { title: '{{ __("Registration Open") }}', value: 'registration_open' },
                { title: '{{ __("Registration Closed") }}', value: 'registration_closed' },
                { title: '{{ __("Completed") }}', value: 'completed' },
                { title: '{{ __("Cancelled") }}', value: 'cancelled' }
            ],
            registrationDialog: false,
            selectedEvent: null,
            registrationForm: {
                notes: ''
            },
            registrationLoading: false,
            deleteDialog: false,
            eventToDelete: null,
            deleteLoading: false
        }
    },
    mounted() {
        this.fetchEvents();
    },
    methods: {
        async fetchEvents() {
            this.loading = true;
            try {
                const response = await axios.get('/api/v1/events');
                this.events = response.data.data;

                if (this.viewMode === 'calendar') {
                    this.$nextTick(() => {
                        this.initializeCalendar();
                    });
                }
            } catch (error) {
                console.error('Error fetching events:', error);
            } finally {
                this.loading = false;
            }
        },
        getEventTypeColor(type) {
            const colors = {
                conference: 'blue',
                workshop: 'green',
                seminar: 'purple',
                training: 'orange',
                meeting: 'grey'
            };
            return colors[type] || 'grey';
        },
        getEventTypeIcon(type) {
            const icons = {
                conference: 'mdi-account-group',
                workshop: 'mdi-hammer-wrench',
                seminar: 'mdi-presentation',
                training: 'mdi-school',
                meeting: 'mdi-calendar-account'
            };
            return icons[type] || 'mdi-calendar';
        },
        getEventTypeText(type) {
            const texts = {
                conference: '{{ __("Conference") }}',
                workshop: '{{ __("Workshop") }}',
                seminar: '{{ __("Seminar") }}',
                training: '{{ __("Training") }}',
                meeting: '{{ __("Meeting") }}'
            };
            return texts[type] || type;
        },
        getStatusColor(status) {
            const colors = {
                draft: 'grey',
                published: 'info',
                registration_open: 'success',
                registration_closed: 'warning',
                completed: 'primary',
                cancelled: 'error'
            };
            return colors[status] || 'grey';
        },
        getStatusIcon(status) {
            const icons = {
                draft: 'mdi-file-document-outline',
                published: 'mdi-publish',
                registration_open: 'mdi-account-plus',
                registration_closed: 'mdi-account-off',
                completed: 'mdi-check-circle',
                cancelled: 'mdi-cancel'
            };
            return icons[status] || 'mdi-help-circle';
        },
        getStatusText(status) {
            const texts = {
                draft: '{{ __("Draft") }}',
                published: '{{ __("Published") }}',
                registration_open: '{{ __("Registration Open") }}',
                registration_closed: '{{ __("Registration Closed") }}',
                completed: '{{ __("Completed") }}',
                cancelled: '{{ __("Cancelled") }}'
            };
            return texts[status] || status;
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },
        formatTime(date) {
            return new Date(date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },
        formatDateTime(date) {
            return new Date(date).toLocaleString();
        },
        canRegister(event) {
            return event.status === 'registration_open' &&
                   (!event.max_participants || event.registrations_count < event.max_participants);
        },
        openRegistrationDialog(event) {
            this.selectedEvent = event;
            this.registrationForm = {
                notes: ''
            };
            this.registrationDialog = true;
        },
        async submitRegistration() {
            this.registrationLoading = true;
            try {
                await axios.post(`/api/v1/events/${this.selectedEvent.id}/register`, {
                    ...this.registrationForm,
                    event_id: this.selectedEvent.id
                });

                this.registrationDialog = false;
                this.fetchEvents();
            } catch (error) {
                console.error('Error registering for event:', error);
            } finally {
                this.registrationLoading = false;
            }
        },
        confirmDelete(event) {
            this.eventToDelete = event;
            this.deleteDialog = true;
        },
        async deleteEvent() {
            this.deleteLoading = true;
            try {
                await axios.delete(`/api/v1/events/${this.eventToDelete.id}`);
                this.deleteDialog = false;
                this.fetchEvents();
            } catch (error) {
                console.error('Error deleting event:', error);
            } finally {
                this.deleteLoading = false;
            }
        },
        initializeCalendar() {
            // Basic calendar implementation - would use a library like FullCalendar in real app
            const calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                calendarEl.innerHTML = '<div class="text-center pa-8"><h3>Calendar View</h3><p>Calendar functionality would be implemented here using a library like FullCalendar</p></div>';
            }
        }
    },
    watch: {
        viewMode(newMode) {
            if (newMode === 'calendar') {
                this.$nextTick(() => {
                    this.initializeCalendar();
                });
            }
        }
    }
});

eventsApp.use(vuetify);
eventsApp.mount('#events-app');
</script>
@endpush