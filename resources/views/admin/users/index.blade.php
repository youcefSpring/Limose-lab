@extends('layouts.app')

@section('content')
<div id="admin-users-app">
    <!-- Page Header -->
    <div class="d-flex justify-space-between align-center mb-6">
        <div>
            <h1 class="text-h4 font-weight-bold">
                {{ __('User Management') }}
            </h1>
            <p class="text-subtitle-1 text-grey-darken-1 mt-1">
                {{ __('Manage system users and their permissions') }}
            </p>
        </div>

        <div class="d-flex ga-2">
            <v-btn
                color="primary"
                prepend-icon="mdi-plus"
                @click="showCreateDialog = true"
            >
                {{ __('Add User') }}
            </v-btn>

            <v-btn
                color="secondary"
                prepend-icon="mdi-download"
                variant="outlined"
                @click="exportUsers"
            >
                {{ __('Export') }}
            </v-btn>
        </div>
    </div>

    <!-- Statistics Cards -->
    <v-row class="mb-6">
        <v-col cols="12" sm="6" md="3">
            <v-card color="primary" variant="flat">
                <v-card-text class="text-white">
                    <div class="d-flex align-center">
                        <div class="flex-grow-1">
                            <div class="text-h4 font-weight-bold">@{{ stats.total_users }}</div>
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
                            <div class="text-h4 font-weight-bold">@{{ stats.active_users }}</div>
                            <div class="text-subtitle-1">{{ __('Active Users') }}</div>
                        </div>
                        <v-icon size="48" class="opacity-75">mdi-check-circle</v-icon>
                    </div>
                </v-card-text>
            </v-card>
        </v-col>

        <v-col cols="12" sm="6" md="3">
            <v-card color="info" variant="flat">
                <v-card-text class="text-white">
                    <div class="d-flex align-center">
                        <div class="flex-grow-1">
                            <div class="text-h4 font-weight-bold">@{{ stats.researchers_count }}</div>
                            <div class="text-subtitle-1">{{ __('Researchers') }}</div>
                        </div>
                        <v-icon size="48" class="opacity-75">mdi-flask</v-icon>
                    </div>
                </v-card-text>
            </v-card>
        </v-col>

        <v-col cols="12" sm="6" md="3">
            <v-card color="warning" variant="flat">
                <v-card-text class="text-white">
                    <div class="d-flex align-center">
                        <div class="flex-grow-1">
                            <div class="text-h4 font-weight-bold">@{{ stats.pending_users }}</div>
                            <div class="text-subtitle-1">{{ __('Pending') }}</div>
                        </div>
                        <v-icon size="48" class="opacity-75">mdi-clock</v-icon>
                    </div>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <!-- Filters -->
    <v-card class="mb-6">
        <v-card-text>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                        v-model="filters.search"
                        :label="'{{ __('Search users...') }}'"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        hide-details
                        clearable
                        @input="searchUsers"
                    ></v-text-field>
                </v-col>

                <v-col cols="12" md="2">
                    <v-select
                        v-model="filters.role"
                        :label="'{{ __('Role') }}'"
                        :items="roleOptions"
                        variant="outlined"
                        clearable
                        hide-details
                        @update:model-value="filterUsers"
                    ></v-select>
                </v-col>

                <v-col cols="12" md="2">
                    <v-select
                        v-model="filters.status"
                        :label="'{{ __('Status') }}'"
                        :items="statusOptions"
                        variant="outlined"
                        clearable
                        hide-details
                        @update:model-value="filterUsers"
                    ></v-select>
                </v-col>

                <v-col cols="12" md="2">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-text-field
                                v-model="dateRangeText"
                                :label="'{{ __('Registration Date') }}'"
                                prepend-inner-icon="mdi-calendar"
                                variant="outlined"
                                readonly
                                hide-details
                                v-bind="props"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="filters.date_range"
                            range
                            @update:model-value="filterUsers"
                        ></v-date-picker>
                    </v-menu>
                </v-col>

                <v-col cols="12" md="2">
                    <div class="d-flex ga-2">
                        <v-btn
                            icon="mdi-filter-off"
                            variant="outlined"
                            @click="clearFilters"
                            :disabled="!hasActiveFilters"
                        ></v-btn>
                        <v-btn
                            icon="mdi-refresh"
                            variant="outlined"
                            @click="loadUsers"
                            :loading="loading"
                        ></v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>

    <!-- Users Table -->
    <v-card>
        <v-card-text>
            <x-data-table
                :headers="tableHeaders"
                :items="users"
                :loading="loading"
                :search="filters.search"
                :items-per-page="pagination.per_page"
                show-select
                @update:selected="selectedUsers = $event"
            >
                <template v-slot:top>
                    <div v-if="selectedUsers.length > 0" class="pa-4 bg-blue-lighten-5">
                        <div class="d-flex align-center justify-space-between">
                            <span class="text-body-1">
                                {{ __(':count users selected', ['count' => '@{{ selectedUsers.length }}']) }}
                            </span>
                            <div class="d-flex ga-2">
                                <v-btn
                                    color="success"
                                    size="small"
                                    @click="bulkAction('activate')"
                                >
                                    {{ __('Activate') }}
                                </v-btn>
                                <v-btn
                                    color="warning"
                                    size="small"
                                    @click="bulkAction('deactivate')"
                                >
                                    {{ __('Deactivate') }}
                                </v-btn>
                                <v-btn
                                    color="error"
                                    size="small"
                                    @click="bulkAction('delete')"
                                >
                                    {{ __('Delete') }}
                                </v-btn>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-slot:item.user="{ item }">
                    <div class="d-flex align-center">
                        <v-avatar size="40" class="me-3">
                            <v-img
                                :src="item.photo_url || '/images/default-avatar.png'"
                                :alt="item.name"
                            ></v-img>
                        </v-avatar>
                        <div>
                            <div class="font-weight-medium">@{{ item.name }}</div>
                            <div class="text-caption text-grey">@{{ item.email }}</div>
                        </div>
                    </div>
                </template>

                <template v-slot:item.role="{ item }">
                    <x-status-chip :status="item.role" />
                </template>

                <template v-slot:item.status="{ item }">
                    <x-status-chip :status="item.status" />
                </template>

                <template v-slot:item.last_login="{ item }">
                    <div v-if="item.last_login">
                        <div class="font-weight-medium">@{{ formatDate(item.last_login) }}</div>
                        <div class="text-caption text-grey">@{{ formatTime(item.last_login) }}</div>
                    </div>
                    <span v-else class="text-grey">{{ __('Never') }}</span>
                </template>

                <template v-slot:item.created_at="{ item }">
                    @{{ formatDate(item.created_at) }}
                </template>

                <template v-slot:item.actions="{ item }">
                    <div class="d-flex ga-1">
                        <v-btn
                            size="small"
                            color="primary"
                            variant="outlined"
                            :to="{ name: 'admin.users.show', params: { user: item.id } }"
                        >
                            {{ __('View') }}
                        </v-btn>
                        <v-btn
                            size="small"
                            color="secondary"
                            variant="text"
                            icon="mdi-pencil"
                            @click="editUser(item)"
                        ></v-btn>
                        <v-btn
                            size="small"
                            :color="item.status === 'active' ? 'warning' : 'success'"
                            variant="text"
                            :icon="item.status === 'active' ? 'mdi-pause' : 'mdi-play'"
                            @click="toggleUserStatus(item)"
                        ></v-btn>
                        <v-btn
                            size="small"
                            color="error"
                            variant="text"
                            icon="mdi-delete"
                            @click="deleteUser(item)"
                        ></v-btn>
                    </div>
                </template>
            </x-data-table>
        </v-card-text>
    </v-card>

    <!-- Pagination -->
    <div v-if="pagination.total_pages > 1" class="d-flex justify-center mt-6">
        <v-pagination
            v-model="pagination.current_page"
            :length="pagination.total_pages"
            :total-visible="7"
            @update:model-value="changePage"
        ></v-pagination>
    </div>

    <!-- Create/Edit User Dialog -->
    <v-dialog v-model="showCreateDialog" max-width="600" persistent>
        <v-card>
            <v-card-title class="d-flex align-center">
                <v-icon class="me-2">mdi-account-plus</v-icon>
                {{ editingUser ? __('Edit User') : __('Create New User') }}
            </v-card-title>

            <v-form @submit.prevent="saveUser" ref="userForm">
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="userForm.name"
                                :label="'{{ __('Full Name') }}'"
                                :rules="[v => !!v || '{{ __('Name is required') }}']"
                                variant="outlined"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="userForm.email"
                                :label="'{{ __('Email') }}'"
                                :rules="emailRules"
                                variant="outlined"
                                type="email"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6" v-if="!editingUser">
                            <v-text-field
                                v-model="userForm.password"
                                :label="'{{ __('Password') }}'"
                                :rules="passwordRules"
                                variant="outlined"
                                type="password"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                v-model="userForm.role"
                                :label="'{{ __('Role') }}'"
                                :items="roleOptions"
                                :rules="[v => !!v || '{{ __('Role is required') }}']"
                                variant="outlined"
                                required
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                v-model="userForm.status"
                                :label="'{{ __('Status') }}'"
                                :items="statusOptions"
                                variant="outlined"
                                required
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="userForm.phone"
                                :label="'{{ __('Phone Number') }}'"
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-card-actions class="px-6 pb-4">
                    <v-spacer></v-spacer>
                    <v-btn @click="closeUserDialog">{{ __('Cancel') }}</v-btn>
                    <v-btn
                        type="submit"
                        color="primary"
                        :loading="saving"
                    >
                        {{ editingUser ? __('Update') : __('Create') }}
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>

    <!-- Confirm Dialog -->
    <x-confirm-dialog ref="confirmDialog" />
</div>
@endsection

@push('scripts')
<script>
const adminUsersApp = createApp({
    data() {
        return {
            users: [],
            selectedUsers: [],
            loading: false,
            saving: false,
            showCreateDialog: false,
            editingUser: null,
            filters: {
                search: '',
                role: null,
                status: null,
                date_range: []
            },
            pagination: {
                current_page: 1,
                total_pages: 1,
                total_items: 0,
                per_page: 15
            },
            stats: {
                total_users: 0,
                active_users: 0,
                researchers_count: 0,
                pending_users: 0
            },
            userForm: {
                name: '',
                email: '',
                password: '',
                role: 'visitor',
                status: 'active',
                phone: ''
            },
            roleOptions: [
                { title: '{{ __("Admin") }}', value: 'admin' },
                { title: '{{ __("Lab Manager") }}', value: 'lab_manager' },
                { title: '{{ __("Researcher") }}', value: 'researcher' },
                { title: '{{ __("Visitor") }}', value: 'visitor' }
            ],
            statusOptions: [
                { title: '{{ __("Active") }}', value: 'active' },
                { title: '{{ __("Inactive") }}', value: 'inactive' },
                { title: '{{ __("Pending") }}', value: 'pending' }
            ],
            tableHeaders: [
                { title: '{{ __("User") }}', key: 'user', sortable: false },
                { title: '{{ __("Role") }}', key: 'role', sortable: true },
                { title: '{{ __("Status") }}', key: 'status', sortable: true },
                { title: '{{ __("Last Login") }}', key: 'last_login', sortable: true },
                { title: '{{ __("Registered") }}', key: 'created_at', sortable: true },
                { title: '{{ __("Actions") }}', key: 'actions', sortable: false, align: 'center' }
            ],
            emailRules: [
                v => !!v || '{{ __("Email is required") }}',
                v => /.+@.+\..+/.test(v) || '{{ __("Email must be valid") }}'
            ],
            passwordRules: [
                v => !!v || '{{ __("Password is required") }}',
                v => v.length >= 8 || '{{ __("Password must be at least 8 characters") }}'
            ]
        }
    },
    computed: {
        hasActiveFilters() {
            return this.filters.search || this.filters.role || this.filters.status ||
                   this.filters.date_range.length > 0;
        },
        dateRangeText() {
            if (this.filters.date_range.length === 2) {
                return `${this.formatDate(this.filters.date_range[0])} - ${this.formatDate(this.filters.date_range[1])}`;
            }
            return '';
        }
    },
    methods: {
        async loadUsers() {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: this.pagination.current_page,
                    per_page: this.pagination.per_page,
                    ...this.filters
                });

                Object.keys(this.filters).forEach(key => {
                    if (!this.filters[key] || (Array.isArray(this.filters[key]) && this.filters[key].length === 0)) {
                        params.delete(key);
                    }
                });

                const response = await axios.get(`/api/v1/users?${params}`);
                const data = response.data.data;

                this.users = data.users;
                this.pagination = data.pagination;
                this.updateStats();
            } catch (error) {
                console.error('Failed to load users:', error);
            } finally {
                this.loading = false;
            }
        },

        async updateStats() {
            this.stats = {
                total_users: this.users.length,
                active_users: this.users.filter(u => u.status === 'active').length,
                researchers_count: this.users.filter(u => u.role === 'researcher').length,
                pending_users: this.users.filter(u => u.status === 'pending').length
            };
        },

        searchUsers: debounce(function() {
            this.pagination.current_page = 1;
            this.loadUsers();
        }, 500),

        filterUsers() {
            this.pagination.current_page = 1;
            this.loadUsers();
        },

        clearFilters() {
            this.filters = {
                search: '',
                role: null,
                status: null,
                date_range: []
            };
            this.pagination.current_page = 1;
            this.loadUsers();
        },

        changePage(page) {
            this.pagination.current_page = page;
            this.loadUsers();
        },

        editUser(user) {
            this.editingUser = user;
            this.userForm = { ...user };
            delete this.userForm.password; // Don't include password in edit
            this.showCreateDialog = true;
        },

        async saveUser() {
            if (!this.$refs.userForm.validate()) return;

            this.saving = true;
            try {
                if (this.editingUser) {
                    await axios.put(`/api/v1/users/${this.editingUser.id}`, this.userForm);
                } else {
                    await axios.post('/api/v1/users', this.userForm);
                }

                this.closeUserDialog();
                this.loadUsers();
            } catch (error) {
                console.error('Failed to save user:', error);
            } finally {
                this.saving = false;
            }
        },

        closeUserDialog() {
            this.showCreateDialog = false;
            this.editingUser = null;
            this.userForm = {
                name: '',
                email: '',
                password: '',
                role: 'visitor',
                status: 'active',
                phone: ''
            };
        },

        async toggleUserStatus(user) {
            try {
                const newStatus = user.status === 'active' ? 'inactive' : 'active';
                await axios.put(`/api/v1/users/${user.id}/status`, { status: newStatus });
                this.loadUsers();
            } catch (error) {
                console.error('Failed to toggle user status:', error);
            }
        },

        async deleteUser(user) {
            const confirmed = await this.$refs.confirmDialog.show({
                title: '{{ __("Delete User") }}',
                message: `{{ __("Are you sure you want to delete :name?", ["name" => "${user.name}"]) }}`,
                confirmText: '{{ __("Delete") }}',
                confirmColor: 'error'
            });

            if (confirmed) {
                try {
                    await axios.delete(`/api/v1/users/${user.id}`);
                    this.loadUsers();
                } catch (error) {
                    console.error('Failed to delete user:', error);
                }
            }
        },

        async bulkAction(action) {
            const userIds = this.selectedUsers.map(u => u.id);

            try {
                await axios.post(`/api/v1/users/bulk-${action}`, { user_ids: userIds });
                this.selectedUsers = [];
                this.loadUsers();
            } catch (error) {
                console.error(`Failed to ${action} users:`, error);
            }
        },

        async exportUsers() {
            try {
                const response = await axios.get('/api/v1/users/export', {
                    params: this.filters,
                    responseType: 'blob'
                });

                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `users-${new Date().toISOString().split('T')[0]}.xlsx`);
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.error('Export failed:', error);
            }
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('{{ app()->getLocale() }}');
        },

        formatTime(datetime) {
            return new Date(datetime).toLocaleTimeString('{{ app()->getLocale() }}', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    },
    mounted() {
        this.loadUsers();
    }
});

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

adminUsersApp.use(vuetify);
adminUsersApp.mount('#admin-users-app');
</script>
@endpush