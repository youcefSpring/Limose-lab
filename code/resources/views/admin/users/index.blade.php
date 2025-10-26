@extends('layouts.adminlte')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ isset($users) ? $users->total() : 0 }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ isset($users) ? $users->where('status', 'active')->count() : 0 }}</h3>
                    <p>Active Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ isset($users) ? $users->where('role', 'researcher')->count() : 0 }}</h3>
                    <p>Researchers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-flask"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ isset($users) ? $users->where('status', 'pending')->count() : 0 }}</h3>
                    <p>Pending Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users mr-1"></i>
                User Management
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>Add User
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search">Search Users</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Name, email...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="lab_manager" {{ request('role') == 'lab_manager' ? 'selected' : '' }}>Lab Manager</option>
                            <option value="researcher" {{ request('role') == 'researcher' ? 'selected' : '' }}>Researcher</option>
                            <option value="visitor" {{ request('role') == 'visitor' ? 'selected' : '' }}>Visitor</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="card-body">
            @if(isset($users) && $users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <img class="img-circle elevation-2"
                                                     src="{{ $user->avatar ?? 'https://via.placeholder.com/40x40/007bff/ffffff?text=' . substr($user->name, 0, 1) }}"
                                                     alt="User Avatar" style="width: 40px; height: 40px;">
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $roleColors = [
                                                'admin' => 'danger',
                                                'lab_manager' => 'success',
                                                'researcher' => 'primary',
                                                'visitor' => 'secondary'
                                            ];
                                            $roleColor = $roleColors[$user->role] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $roleColor }}">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'active' => 'success',
                                                'inactive' => 'secondary',
                                                'pending' => 'warning'
                                            ];
                                            $statusColor = $statusColors[$user->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $statusColor }}">{{ ucfirst($user->status) }}</span>
                                    </td>
                                    <td>
                                        @if($user->last_login_at)
                                            <div>{{ $user->last_login_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $user->last_login_at->format('H:i') }}</small>
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $user->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <div class="card-tools float-right">
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-users fa-5x text-muted mb-4"></i>
                        <h4 class="text-muted">No Users Found</h4>
                        @if(request()->hasAny(['search', 'role', 'status']))
                            <p class="text-muted">No users match your search criteria.</p>
                            <a href="{{ route('admin.users') }}" class="btn btn-primary">
                                <i class="fas fa-times mr-1"></i>Clear Filters
                            </a>
                        @else
                            <p class="text-muted">No users have been created yet.</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i>Add First User
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

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
                    <v-chip
                        :color="getStatusColor(item.role)"
                        size="small"
                        variant="flat"
                    >
                        <template v-slot:prepend>
                            <v-icon size="small">@{{ getStatusIcon(item.role) }}</v-icon>
                        </template>
                        @{{ getStatusText(item.role) }}
                    </v-chip>
                </template>

                <template v-slot:item.status="{ item }">
                    <v-chip
                        :color="getStatusColor(item.status)"
                        size="small"
                        variant="flat"
                    >
                        <template v-slot:prepend>
                            <v-icon size="small">@{{ getStatusIcon(item.status) }}</v-icon>
                        </template>
                        @{{ getStatusText(item.status) }}
                    </v-chip>
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
        },

        getStatusColor(status) {
            const colors = {
                'active': 'success',
                'inactive': 'grey',
                'pending': 'warning',
                'completed': 'success',
                'cancelled': 'error',
                'suspended': 'orange',
                'admin': 'red',
                'researcher': 'blue',
                'lab_manager': 'green',
                'visitor': 'grey'
            };
            return colors[status] || 'grey';
        },

        getStatusIcon(status) {
            const icons = {
                'active': 'mdi-check-circle',
                'inactive': 'mdi-pause-circle',
                'pending': 'mdi-clock',
                'completed': 'mdi-check',
                'cancelled': 'mdi-cancel',
                'suspended': 'mdi-pause',
                'admin': 'mdi-shield-crown',
                'researcher': 'mdi-flask',
                'lab_manager': 'mdi-microscope',
                'visitor': 'mdi-account-eye'
            };
            return icons[status] || 'mdi-help';
        },

        getStatusText(status) {
            const texts = {
                'active': '{{ __("Active") }}',
                'inactive': '{{ __("Inactive") }}',
                'pending': '{{ __("Pending") }}',
                'completed': '{{ __("Completed") }}',
                'cancelled': '{{ __("Cancelled") }}',
                'suspended': '{{ __("Suspended") }}',
                'admin': '{{ __("Admin") }}',
                'researcher': '{{ __("Researcher") }}',
                'lab_manager': '{{ __("Lab Manager") }}',
                'visitor': '{{ __("Visitor") }}'
            };
            return texts[status] || status.charAt(0).toUpperCase() + status.slice(1);
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