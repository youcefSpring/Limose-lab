@extends('layouts.app', ['title' => __('Collaborations Management')])

@section('content')
<div id="collaborations-app">
    <div class="d-flex justify-space-between align-center mb-6">
        <div>
            <h2 class="text-h4 font-weight-bold">{{ __('International Collaborations') }}</h2>
            <p class="text-body-1 text-grey">{{ __('Manage partnerships with international research institutions') }}</p>
        </div>
        @can('create', App\Models\Collaboration::class)
        <v-btn
            color="primary"
            prepend-icon="mdi-plus"
            href="{{ route('collaborations.create') }}"
        >
            {{ __('New Collaboration') }}
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
                        :label="'{{ __('Search collaborations...') }}'"
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
                        :items="collaborationTypes"
                        :label="'{{ __('Collaboration Type') }}'"
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
                    <v-autocomplete
                        v-model="filters.country"
                        :items="countries"
                        :label="'{{ __('Country') }}'"
                        variant="outlined"
                        density="compact"
                        hide-details
                        clearable
                    ></v-autocomplete>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>

    <!-- Collaborations Data Table -->
    <v-card>
        <v-data-table
            :headers="headers"
            :items="collaborations"
            :loading="loading"
            :search="filters.search"
            item-value="id"
            class="elevation-0"
        >
            <!-- Partner Institution Column -->
            <template #item.partner_institution="{ item }">
                <div class="d-flex align-center">
                    <v-avatar class="mr-3" size="40" color="primary">
                        <v-icon>mdi-bank</v-icon>
                    </v-avatar>
                    <div>
                        <div class="font-weight-medium">@{{ item.partner_institution }}</div>
                        <div class="text-caption text-grey d-flex align-center">
                            <v-icon size="12" class="mr-1">mdi-map-marker</v-icon>
                            @{{ item.country }}
                        </div>
                    </div>
                </div>
            </template>

            <!-- Type Column -->
            <template #item.type="{ item }">
                <v-chip
                    :color="getCollaborationTypeColor(item.type)"
                    variant="tonal"
                    size="small"
                >
                    @{{ getCollaborationTypeText(item.type) }}
                </v-chip>
            </template>

            <!-- Contact Person Column -->
            <template #item.contact_person="{ item }">
                <div v-if="item.contact_person">
                    <div class="text-body-2">@{{ item.contact_person }}</div>
                    <div v-if="item.contact_email" class="text-caption text-grey">
                        @{{ item.contact_email }}
                    </div>
                </div>
                <span v-else class="text-grey">-</span>
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

            <!-- Duration Column -->
            <template #item.start_date="{ item }">
                <div>
                    <div class="text-body-2">@{{ formatDate(item.start_date) }}</div>
                    <div v-if="item.end_date" class="text-caption text-grey">
                        {{ __('to') }} @{{ formatDate(item.end_date) }}
                    </div>
                    <div v-else class="text-caption text-info">
                        {{ __('Ongoing') }}
                    </div>
                </div>
            </template>

            <!-- Projects Count Column -->
            <template #item.projects_count="{ item }">
                <div class="text-center">
                    <div class="font-weight-medium">@{{ item.projects_count || 0 }}</div>
                    <div class="text-caption text-grey">{{ __('projects') }}</div>
                </div>
            </template>

            <!-- Actions Column -->
            <template #item.actions="{ item }">
                <div class="d-flex ga-2">
                    <v-btn
                        icon="mdi-eye"
                        size="small"
                        variant="text"
                        :href="`/collaborations/${item.id}`"
                    ></v-btn>

                    @can('update', App\Models\Collaboration::class)
                    <v-btn
                        icon="mdi-pencil"
                        size="small"
                        variant="text"
                        :href="`/collaborations/${item.id}/edit`"
                    ></v-btn>
                    @endcan

                    @can('delete', App\Models\Collaboration::class)
                    <v-btn
                        icon="mdi-delete"
                        size="small"
                        variant="text"
                        color="error"
                        @click="confirmDelete(item)"
                    ></v-btn>
                    @endcan

                    <v-btn
                        icon="mdi-email"
                        size="small"
                        variant="text"
                        color="primary"
                        @click="sendEmail(item)"
                        :disabled="!item.contact_email"
                    ></v-btn>

                    <v-btn
                        icon="mdi-calendar-plus"
                        size="small"
                        variant="text"
                        color="success"
                        @click="scheduleActivity(item)"
                    ></v-btn>
                </div>
            </template>
        </v-data-table>
    </v-card>

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="deleteDialog" max-width="400">
        <v-card>
            <v-card-title class="text-h5">{{ __('Confirm Delete') }}</v-card-title>
            <v-card-text>
                {{ __('Are you sure you want to delete this collaboration? This action cannot be undone.') }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="deleteDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="error" @click="deleteCollaboration" :loading="deleteLoading">
                    {{ __('Delete') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Email Dialog -->
    <v-dialog v-model="emailDialog" max-width="600">
        <v-card>
            <v-card-title>
                <span class="text-h5">{{ __('Send Email') }}</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="emailForm">
                    <v-row>
                        <v-col cols="12">
                            <div class="d-flex align-center mb-4">
                                <v-avatar color="primary" class="mr-3">
                                    <v-icon>mdi-bank</v-icon>
                                </v-avatar>
                                <div>
                                    <div class="font-weight-medium">@{{ selectedCollaboration?.partner_institution }}</div>
                                    <div class="text-caption text-grey">@{{ selectedCollaboration?.contact_person }}</div>
                                </div>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                v-model="emailForm.subject"
                                :label="'{{ __('Subject') }}'"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                v-model="emailForm.message"
                                :label="'{{ __('Message') }}'"
                                variant="outlined"
                                rows="6"
                                required
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="emailDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="primary" @click="submitEmail" :loading="emailLoading">
                    {{ __('Send Email') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Activity Dialog -->
    <v-dialog v-model="activityDialog" max-width="600">
        <v-card>
            <v-card-title>
                <span class="text-h5">{{ __('Schedule Activity') }}</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="activityForm">
                    <v-row>
                        <v-col cols="12">
                            <div class="d-flex align-center mb-4">
                                <v-avatar color="primary" class="mr-3">
                                    <v-icon>mdi-bank</v-icon>
                                </v-avatar>
                                <div>
                                    <div class="font-weight-medium">@{{ selectedCollaboration?.partner_institution }}</div>
                                </div>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                v-model="activityForm.title"
                                :label="'{{ __('Activity Title') }}'"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="activityForm.date"
                                :label="'{{ __('Date') }}'"
                                type="date"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="activityForm.time"
                                :label="'{{ __('Time') }}'"
                                type="time"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                v-model="activityForm.description"
                                :label="'{{ __('Description') }}'"
                                variant="outlined"
                                rows="3"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="activityDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="primary" @click="submitActivity" :loading="activityLoading">
                    {{ __('Schedule') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Statistics Cards -->
    <v-row class="mt-6">
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-primary">@{{ stats.totalCollaborations }}</div>
                    <div class="text-body-2 text-grey">{{ __('Total Collaborations') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-success">@{{ stats.activeCollaborations }}</div>
                    <div class="text-body-2 text-grey">{{ __('Active') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-info">@{{ stats.uniqueCountries }}</div>
                    <div class="text-body-2 text-grey">{{ __('Countries') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-warning">@{{ stats.jointProjects }}</div>
                    <div class="text-body-2 text-grey">{{ __('Joint Projects') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</div>
@endsection

@push('scripts')
<script>
const collaborationsApp = createApp({
    data() {
        return {
            loading: false,
            collaborations: [],
            stats: {
                totalCollaborations: 0,
                activeCollaborations: 0,
                uniqueCountries: 0,
                jointProjects: 0
            },
            filters: {
                search: '',
                type: null,
                status: null,
                country: null
            },
            headers: [
                { title: '{{ __("Partner Institution") }}', key: 'partner_institution', sortable: true },
                { title: '{{ __("Type") }}', key: 'type', sortable: true },
                { title: '{{ __("Contact Person") }}', key: 'contact_person', sortable: true },
                { title: '{{ __("Status") }}', key: 'status', sortable: true },
                { title: '{{ __("Duration") }}', key: 'start_date', sortable: true },
                { title: '{{ __("Projects") }}', key: 'projects_count', sortable: true },
                { title: '{{ __("Actions") }}', key: 'actions', sortable: false, width: 250 }
            ],
            collaborationTypes: [
                { title: '{{ __("Research Partnership") }}', value: 'research_partnership' },
                { title: '{{ __("Student Exchange") }}', value: 'student_exchange' },
                { title: '{{ __("Joint Program") }}', value: 'joint_program' },
                { title: '{{ __("Equipment Sharing") }}', value: 'equipment_sharing' },
                { title: '{{ __("Knowledge Exchange") }}', value: 'knowledge_exchange' },
                { title: '{{ __("Funding Partnership") }}', value: 'funding_partnership' }
            ],
            statusOptions: [
                { title: '{{ __("Active") }}', value: 'active' },
                { title: '{{ __("Pending") }}', value: 'pending' },
                { title: '{{ __("Completed") }}', value: 'completed' },
                { title: '{{ __("Suspended") }}', value: 'suspended' },
                { title: '{{ __("Terminated") }}', value: 'terminated' }
            ],
            countries: [
                { title: 'United States', value: 'United States' },
                { title: 'United Kingdom', value: 'United Kingdom' },
                { title: 'Germany', value: 'Germany' },
                { title: 'France', value: 'France' },
                { title: 'Canada', value: 'Canada' },
                { title: 'Australia', value: 'Australia' },
                { title: 'Japan', value: 'Japan' },
                { title: 'South Korea', value: 'South Korea' },
                { title: 'China', value: 'China' },
                { title: 'India', value: 'India' }
            ],
            deleteDialog: false,
            collaborationToDelete: null,
            deleteLoading: false,
            emailDialog: false,
            selectedCollaboration: null,
            emailForm: {
                subject: '',
                message: ''
            },
            emailLoading: false,
            activityDialog: false,
            activityForm: {
                title: '',
                date: '',
                time: '',
                description: ''
            },
            activityLoading: false
        }
    },
    mounted() {
        this.fetchCollaborations();
        this.fetchStats();
    },
    methods: {
        async fetchCollaborations() {
            this.loading = true;
            try {
                const response = await axios.get('/api/v1/collaborations');
                this.collaborations = response.data.data;
            } catch (error) {
                console.error('Error fetching collaborations:', error);
            } finally {
                this.loading = false;
            }
        },
        async fetchStats() {
            try {
                const response = await axios.get('/api/v1/collaborations/stats');
                this.stats = response.data.data;
            } catch (error) {
                console.error('Error fetching collaboration stats:', error);
            }
        },
        getCollaborationTypeColor(type) {
            const colors = {
                research_partnership: 'blue',
                student_exchange: 'green',
                joint_program: 'purple',
                equipment_sharing: 'orange',
                knowledge_exchange: 'teal',
                funding_partnership: 'red'
            };
            return colors[type] || 'grey';
        },
        getCollaborationTypeText(type) {
            const texts = {
                research_partnership: '{{ __("Research Partnership") }}',
                student_exchange: '{{ __("Student Exchange") }}',
                joint_program: '{{ __("Joint Program") }}',
                equipment_sharing: '{{ __("Equipment Sharing") }}',
                knowledge_exchange: '{{ __("Knowledge Exchange") }}',
                funding_partnership: '{{ __("Funding Partnership") }}'
            };
            return texts[type] || type;
        },
        getStatusColor(status) {
            const colors = {
                active: 'success',
                pending: 'warning',
                completed: 'primary',
                suspended: 'orange',
                terminated: 'error'
            };
            return colors[status] || 'grey';
        },
        getStatusIcon(status) {
            const icons = {
                active: 'mdi-check-circle',
                pending: 'mdi-clock',
                completed: 'mdi-flag-checkered',
                suspended: 'mdi-pause-circle',
                terminated: 'mdi-cancel'
            };
            return icons[status] || 'mdi-help-circle';
        },
        getStatusText(status) {
            const texts = {
                active: '{{ __("Active") }}',
                pending: '{{ __("Pending") }}',
                completed: '{{ __("Completed") }}',
                suspended: '{{ __("Suspended") }}',
                terminated: '{{ __("Terminated") }}'
            };
            return texts[status] || status;
        },
        formatDate(date) {
            if (!date) return null;
            return new Date(date).toLocaleDateString();
        },
        confirmDelete(collaboration) {
            this.collaborationToDelete = collaboration;
            this.deleteDialog = true;
        },
        async deleteCollaboration() {
            this.deleteLoading = true;
            try {
                await axios.delete(`/api/v1/collaborations/${this.collaborationToDelete.id}`);
                this.deleteDialog = false;
                this.fetchCollaborations();
                this.fetchStats();
            } catch (error) {
                console.error('Error deleting collaboration:', error);
            } finally {
                this.deleteLoading = false;
            }
        },
        sendEmail(collaboration) {
            this.selectedCollaboration = collaboration;
            this.emailForm = {
                subject: '',
                message: ''
            };
            this.emailDialog = true;
        },
        async submitEmail() {
            this.emailLoading = true;
            try {
                await axios.post(`/api/v1/collaborations/${this.selectedCollaboration.id}/email`, {
                    ...this.emailForm,
                    recipient: this.selectedCollaboration.contact_email
                });
                this.emailDialog = false;
            } catch (error) {
                console.error('Error sending email:', error);
            } finally {
                this.emailLoading = false;
            }
        },
        scheduleActivity(collaboration) {
            this.selectedCollaboration = collaboration;
            this.activityForm = {
                title: '',
                date: '',
                time: '',
                description: ''
            };
            this.activityDialog = true;
        },
        async submitActivity() {
            this.activityLoading = true;
            try {
                await axios.post(`/api/v1/collaborations/${this.selectedCollaboration.id}/activities`, {
                    ...this.activityForm,
                    collaboration_id: this.selectedCollaboration.id
                });
                this.activityDialog = false;
            } catch (error) {
                console.error('Error scheduling activity:', error);
            } finally {
                this.activityLoading = false;
            }
        }
    }
});

collaborationsApp.use(vuetify);
collaborationsApp.mount('#collaborations-app');
</script>
@endpush