<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                <a href="{{ route('projects.show', $project) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Manage Team Members') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $project->title }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Add Member Form -->
            <div class="lg:col-span-1">
                <x-card>
                    <x-slot name="title">{{ __('Add Team Member') }}</x-slot>
                    <form method="POST" action="{{ route('projects.members.add', $project) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Select User') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" id="user_id" required
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('user_id') border-red-500 @enderror">
                                <option value="">{{ __('Choose a user') }}</option>
                                @foreach($availableUsers ?? [] as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Role') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="role" id="role" required
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror">
                                <option value="member">{{ __('Member') }}</option>
                                <option value="researcher">{{ __('Researcher') }}</option>
                                <option value="assistant">{{ __('Assistant') }}</option>
                                <option value="coordinator">{{ __('Coordinator') }}</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Responsibilities') }}
                            </label>
                            <textarea name="responsibilities" id="responsibilities" rows="3"
                                placeholder="{{ __('Describe member responsibilities...') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('responsibilities') border-red-500 @enderror">{{ old('responsibilities') }}</textarea>
                            @error('responsibilities')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-button variant="primary" type="submit" class="w-full">
                            <svg class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('Add Member') }}
                        </x-button>
                    </form>
                </x-card>

                <!-- Project Stats -->
                <x-card class="mt-6">
                    <x-slot name="title">{{ __('Team Statistics') }}</x-slot>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total Members') }}</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $project->members?->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Researchers') }}</span>
                            <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                {{ $project->members?->where('pivot.role', 'researcher')->count() ?? 0 }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Assistants') }}</span>
                            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                {{ $project->members?->where('pivot.role', 'assistant')->count() ?? 0 }}
                            </span>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Current Members List -->
            <div class="lg:col-span-2">
                <x-card>
                    <x-slot name="title">{{ __('Current Team Members') }} ({{ $project->members?->count() ?? 0 }})</x-slot>

                    @if($project->members && $project->members->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->members as $member)
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-start justify-between">
                                        <!-- Member Info -->
                                        <div class="flex items-start space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} flex-1">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-lg flex-shrink-0">
                                                {{ substr($member->name, 0, 2) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $member->name }}
                                                    </h3>
                                                    <x-badge :status="$member->pivot->role ?? 'member'" size="sm">
                                                        {{ __(ucfirst($member->pivot->role ?? 'member')) }}
                                                    </x-badge>
                                                    @if($member->id == $project->principal_investigator_id)
                                                        <x-badge status="active" size="sm">
                                                            {{ __('PI') }}
                                                        </x-badge>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $member->email }}
                                                </p>
                                                @if($member->pivot->responsibilities)
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                                                        <strong>{{ __('Responsibilities') }}:</strong> {{ $member->pivot->responsibilities }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                                    {{ __('Joined') }}: {{ $member->pivot->created_at?->format('M d, Y') ?? __('N/A') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} {{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                                            <!-- Edit Member Button -->
                                            <button type="button"
                                                onclick="openEditModal({{ $member->id }}, '{{ $member->pivot->role }}', '{{ addslashes($member->pivot->responsibilities ?? '') }}')"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>

                                            <!-- Remove Member (if not PI) -->
                                            @if($member->id != $project->principal_investigator_id)
                                                <form method="POST" action="{{ route('projects.members.remove', [$project, $member]) }}"
                                                    onsubmit="return confirm('{{ __('Are you sure you want to remove this member?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="mt-4 text-gray-500 dark:text-gray-400">
                                {{ __('No team members yet. Add your first member to get started.') }}
                            </p>
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeEditModal(event)">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Edit Member') }}</h3>
            <form id="editMemberForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Role') }}
                    </label>
                    <select name="role" id="edit_role" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="member">{{ __('Member') }}</option>
                        <option value="researcher">{{ __('Researcher') }}</option>
                        <option value="assistant">{{ __('Assistant') }}</option>
                        <option value="coordinator">{{ __('Coordinator') }}</option>
                    </select>
                </div>

                <div>
                    <label for="edit_responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Responsibilities') }}
                    </label>
                    <textarea name="responsibilities" id="edit_responsibilities" rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <x-button variant="outline" type="button" onclick="closeEditModal()" class="flex-1">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button variant="primary" type="submit" class="flex-1">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditModal(userId, role, responsibilities) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editMemberForm');
            form.action = `{{ route('projects.members.update', [$project, '__USER__']) }}`.replace('__USER__', userId);
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_responsibilities').value = responsibilities;
            modal.classList.remove('hidden');
        }

        function closeEditModal(event) {
            if (!event || event.target.id === 'editModal') {
                document.getElementById('editModal').classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>
