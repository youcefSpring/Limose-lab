<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    /**
     * Create a new project.
     *
     * @param User $creator
     * @param array $data
     * @return Project
     */
    public function createProject(User $creator, array $data): Project
    {
        return DB::transaction(function () use ($creator, $data) {
            $project = Project::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'project_type' => $data['project_type'] ?? null,
                'status' => 'active',
                'created_by' => $creator->id,
            ]);

            // Automatically add creator as owner
            $project->users()->attach($creator->id, [
                'role' => 'owner',
                'joined_at' => now(),
            ]);

            // Add other members if provided
            if (isset($data['members']) && is_array($data['members'])) {
                foreach ($data['members'] as $memberId) {
                    if ($memberId != $creator->id) {
                        $project->users()->attach($memberId, [
                            'role' => 'member',
                            'joined_at' => now(),
                        ]);
                    }
                }
            }

            return $project->fresh('users');
        });
    }

    /**
     * Update a project.
     *
     * @param Project $project
     * @param array $data
     * @return Project
     */
    public function updateProject(Project $project, array $data): Project
    {
        $project->update([
            'title' => $data['title'] ?? $project->title,
            'description' => $data['description'] ?? $project->description,
            'start_date' => $data['start_date'] ?? $project->start_date,
            'end_date' => $data['end_date'] ?? $project->end_date,
            'project_type' => $data['project_type'] ?? $project->project_type,
            'status' => $data['status'] ?? $project->status,
        ]);

        return $project->fresh();
    }

    /**
     * Add a member to the project.
     *
     * @param Project $project
     * @param User $user
     * @param string $role
     * @return bool
     */
    public function addMember(Project $project, User $user, string $role = 'member'): bool
    {
        if ($project->hasMember($user)) {
            return false;
        }

        $project->users()->attach($user->id, [
            'role' => $role,
            'joined_at' => now(),
        ]);

        return true;
    }

    /**
     * Remove a member from the project.
     *
     * @param Project $project
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function removeMember(Project $project, User $user): bool
    {
        // Cannot remove the last owner
        if ($project->hasOwner($user)) {
            $ownerCount = $project->owners()->count();
            if ($ownerCount <= 1) {
                throw new \Exception('Cannot remove the last owner of the project');
            }
        }

        $project->users()->detach($user->id);
        return true;
    }

    /**
     * Change a member's role.
     *
     * @param Project $project
     * @param User $user
     * @param string $newRole
     * @return bool
     * @throws \Exception
     */
    public function changeMemberRole(Project $project, User $user, string $newRole): bool
    {
        if (!$project->hasMember($user)) {
            throw new \Exception('User is not a member of this project');
        }

        // If changing from owner to something else, ensure not the last owner
        if ($project->hasOwner($user) && $newRole !== 'owner') {
            $ownerCount = $project->owners()->count();
            if ($ownerCount <= 1) {
                throw new \Exception('Cannot change role: this is the last owner of the project');
            }
        }

        $project->users()->updateExistingPivot($user->id, ['role' => $newRole]);
        return true;
    }

    /**
     * Archive a project.
     *
     * @param Project $project
     * @return Project
     */
    public function archiveProject(Project $project): Project
    {
        $project->update(['status' => 'archived']);
        return $project->fresh();
    }

    /**
     * Complete a project.
     *
     * @param Project $project
     * @return Project
     */
    public function completeProject(Project $project): Project
    {
        $project->update(['status' => 'completed']);
        return $project->fresh();
    }

    /**
     * Reactivate a project.
     *
     * @param Project $project
     * @return Project
     */
    public function reactivateProject(Project $project): Project
    {
        $project->update(['status' => 'active']);
        return $project->fresh();
    }

    /**
     * Get user's projects.
     *
     * @param User $user
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserProjects(User $user, ?string $status = null)
    {
        $query = $user->projects()->with('creator', 'users');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Check if user can manage project (is owner or admin).
     *
     * @param Project $project
     * @param User $user
     * @return bool
     */
    public function canManageProject(Project $project, User $user): bool
    {
        return $project->hasOwner($user) || $user->hasRole('admin');
    }

    /**
     * Get project statistics.
     *
     * @param Project $project
     * @return array
     */
    public function getProjectStatistics(Project $project): array
    {
        return [
            'total_members' => $project->users()->count(),
            'total_experiments' => $project->experiments()->count(),
            'total_comments' => $project->experiments()->withCount('comments')->get()->sum('comments_count'),
            'recent_experiments' => $project->experiments()->latest()->take(5)->get(),
            'duration_days' => $project->start_date->diffInDays($project->end_date ?? now()),
        ];
    }
}
