<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Researcher;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of projects with filters.
     */
    public function getProjects(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Project::with(['leader.user', 'members', 'funding']);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->byTitle($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (!empty($filters['leader_id'])) {
            $query->where('leader_id', $filters['leader_id']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->byDateRange($filters['start_date'], $filters['end_date']);
        }

        if (!empty($filters['budget_min']) && !empty($filters['budget_max'])) {
            $query->whereBetween('budget', [$filters['budget_min'], $filters['budget_max']]);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Create a new project with workflow validation.
     */
    public function createProject(array $projectData, Researcher $leader): Project
    {
        return DB::transaction(function () use ($projectData, $leader) {
            // Validate project dates
            $this->validateProjectDates($projectData['start_date'], $projectData['end_date']);

            // Create project
            $project = Project::create([
                'leader_id' => $leader->id,
                'title_ar' => $projectData['title_ar'],
                'title_fr' => $projectData['title_fr'],
                'title_en' => $projectData['title_en'],
                'description_ar' => $projectData['description_ar'] ?? null,
                'description_fr' => $projectData['description_fr'] ?? null,
                'description_en' => $projectData['description_en'] ?? null,
                'budget' => $projectData['budget'],
                'start_date' => $projectData['start_date'],
                'end_date' => $projectData['end_date'],
                'status' => 'pending', // Always starts as pending
            ]);

            // Add leader as first member
            $this->addProjectMember($project, $leader, 'principal_investigator');

            // Add other members if provided
            if (!empty($projectData['member_ids'])) {
                foreach ($projectData['member_ids'] as $memberId) {
                    $member = Researcher::findOrFail($memberId);
                    $this->addProjectMember($project, $member, 'member');
                }
            }

            // Notify admin for approval
            $this->notificationService->notifyAdminsOfNewProject($project);

            return $project->load(['leader.user', 'members']);
        });
    }

    /**
     * Update project information.
     */
    public function updateProject(Project $project, array $updateData): Project
    {
        return DB::transaction(function () use ($project, $updateData) {
            // Validate business rules
            if (isset($updateData['status'])) {
                $this->validateStatusTransition($project->status, $updateData['status']);
            }

            if (isset($updateData['start_date'], $updateData['end_date'])) {
                $this->validateProjectDates($updateData['start_date'], $updateData['end_date']);
            }

            // Update project
            $project->update($updateData);

            // Notify team members of significant changes
            if (isset($updateData['status']) && $updateData['status'] !== $project->getOriginal('status')) {
                $this->notificationService->notifyProjectStatusChange($project, $project->getOriginal('status'));
            }

            return $project->fresh(['leader.user', 'members']);
        });
    }

    /**
     * Change project status with workflow validation.
     */
    public function changeProjectStatus(Project $project, string $newStatus, User $user, string $reason = null): Project
    {
        return DB::transaction(function () use ($project, $newStatus, $user, $reason) {
            $oldStatus = $project->status;

            // Validate status transition
            $this->validateStatusTransition($oldStatus, $newStatus);

            // Check user permissions for status change
            $this->validateStatusChangePermission($user, $oldStatus, $newStatus);

            // Update project status
            $project->update(['status' => $newStatus]);

            // Log status change
            \Log::info("Project {$project->id} status changed from {$oldStatus} to {$newStatus} by user {$user->id}", [
                'project_id' => $project->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => $user->id,
                'reason' => $reason,
            ]);

            // Send notifications
            $this->notificationService->notifyProjectStatusChange($project, $oldStatus);

            return $project;
        });
    }

    /**
     * Add member to project.
     */
    public function addProjectMember(Project $project, Researcher $researcher, string $role = 'member'): ProjectMember
    {
        // Check if already a member
        if ($project->members()->where('researcher_id', $researcher->id)->exists()) {
            throw ValidationException::withMessages([
                'researcher_id' => ['الباحث عضو في المشروع بالفعل'],
            ]);
        }

        $member = ProjectMember::create([
            'project_id' => $project->id,
            'researcher_id' => $researcher->id,
            'role' => $role,
            'joined_at' => now(),
        ]);

        // Notify the researcher
        $this->notificationService->notifyResearcherAddedToProject($researcher, $project);

        return $member;
    }

    /**
     * Remove member from project.
     */
    public function removeProjectMember(Project $project, Researcher $researcher): bool
    {
        // Cannot remove project leader
        if ($project->leader_id === $researcher->id) {
            throw ValidationException::withMessages([
                'researcher_id' => ['لا يمكن إزالة قائد المشروع'],
            ]);
        }

        $member = ProjectMember::where('project_id', $project->id)
                              ->where('researcher_id', $researcher->id)
                              ->first();

        if (!$member) {
            throw ValidationException::withMessages([
                'researcher_id' => ['الباحث ليس عضوًا في المشروع'],
            ]);
        }

        // Notify the researcher
        $this->notificationService->notifyResearcherRemovedFromProject($researcher, $project);

        return $member->delete();
    }

    /**
     * Update project member role.
     */
    public function updateMemberRole(Project $project, Researcher $researcher, string $newRole): ProjectMember
    {
        $member = ProjectMember::where('project_id', $project->id)
                              ->where('researcher_id', $researcher->id)
                              ->firstOrFail();

        $member->update(['role' => $newRole]);

        return $member;
    }

    /**
     * Get project statistics and metrics.
     */
    public function getProjectStatistics(Project $project): array
    {
        return [
            'team_size' => $project->members()->count(),
            'duration_days' => $project->duration,
            'budget_allocated' => $project->budget,
            'publications_count' => $project->publications()->count(),
            'equipment_reservations' => $project->equipmentReservations()->count(),
            'funding_sources' => $project->funding()->count(),
            'total_funding' => $project->funding()->sum('amount'),
            'progress_percentage' => $this->calculateProjectProgress($project),
            'days_remaining' => max(0, now()->diffInDays($project->end_date)),
            'team_members' => $project->members()->with('researcher.user')->get()->map(function ($member) {
                return [
                    'name' => $member->researcher->full_name,
                    'role' => $member->role,
                    'joined_at' => $member->joined_at,
                ];
            }),
        ];
    }

    /**
     * Get projects dashboard data for researcher.
     */
    public function getResearcherDashboard(Researcher $researcher): array
    {
        $ledProjects = $researcher->ledProjects()->with(['members', 'funding'])->get();
        $memberProjects = $researcher->projects()->with(['leader.user', 'funding'])->get();

        return [
            'led_projects' => $ledProjects,
            'member_projects' => $memberProjects,
            'statistics' => [
                'total_projects' => $ledProjects->count() + $memberProjects->count(),
                'active_projects' => $ledProjects->where('status', 'active')->count() +
                                   $memberProjects->where('status', 'active')->count(),
                'completed_projects' => $ledProjects->where('status', 'completed')->count() +
                                       $memberProjects->where('status', 'completed')->count(),
                'total_budget_led' => $ledProjects->sum('budget'),
                'total_team_members' => $ledProjects->sum(function ($project) {
                    return $project->members->count();
                }),
            ],
        ];
    }

    /**
     * Search projects by multiple criteria.
     */
    public function searchProjects(string $query, array $filters = []): Collection
    {
        $searchQuery = Project::with(['leader.user', 'members'])
            ->byTitle($query);

        // Apply additional filters
        if (!empty($filters['status'])) {
            $searchQuery->byStatus($filters['status']);
        }

        if (!empty($filters['leader_id'])) {
            $searchQuery->where('leader_id', $filters['leader_id']);
        }

        return $searchQuery->limit(50)->get();
    }

    /**
     * Calculate project progress percentage.
     */
    private function calculateProjectProgress(Project $project): float
    {
        $totalDays = $project->start_date->diffInDays($project->end_date);
        $elapsedDays = $project->start_date->diffInDays(now());

        if ($totalDays <= 0) {
            return 100.0;
        }

        $progress = min(100.0, max(0.0, ($elapsedDays / $totalDays) * 100));

        return round($progress, 1);
    }

    /**
     * Validate project dates.
     */
    private function validateProjectDates(string $startDate, string $endDate): void
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        if ($start->gte($end)) {
            throw ValidationException::withMessages([
                'end_date' => ['تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية'],
            ]);
        }

        if ($start->isPast()) {
            throw ValidationException::withMessages([
                'start_date' => ['تاريخ البداية لا يمكن أن يكون في الماضي'],
            ]);
        }
    }

    /**
     * Validate status transition.
     */
    private function validateStatusTransition(string $currentStatus, string $newStatus): void
    {
        $allowedTransitions = [
            'pending' => ['active', 'suspended'],
            'active' => ['completed', 'suspended'],
            'suspended' => ['active'],
            'completed' => [], // No transitions from completed
        ];

        if (!isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            throw ValidationException::withMessages([
                'status' => ["لا يمكن تغيير حالة المشروع من {$currentStatus} إلى {$newStatus}"],
            ]);
        }
    }

    /**
     * Validate user permission for status change.
     */
    private function validateStatusChangePermission(User $user, string $oldStatus, string $newStatus): void
    {
        // Admin can change any status
        if ($user->isAdmin()) {
            return;
        }

        // Lab managers can approve pending projects
        if ($user->isLabManager() && $oldStatus === 'pending' && $newStatus === 'active') {
            return;
        }

        // Project leaders can complete their projects
        if ($user->isResearcher() && $oldStatus === 'active' && $newStatus === 'completed') {
            return;
        }

        throw ValidationException::withMessages([
            'status' => ['ليس لديك صلاحية لتغيير حالة المشروع'],
        ]);
    }

    /**
     * Archive completed projects.
     */
    public function archiveProject(Project $project): bool
    {
        if ($project->status !== 'completed') {
            throw ValidationException::withMessages([
                'status' => ['يمكن أرشفة المشاريع المكتملة فقط'],
            ]);
        }

        // Update status to archived (you might want to add this status to the enum)
        return $project->update(['status' => 'completed']); // For now, keep as completed
    }

    /**
     * Get project timeline and milestones.
     */
    public function getProjectTimeline(Project $project): array
    {
        $timeline = [];

        // Project creation
        $timeline[] = [
            'date' => $project->created_at,
            'event' => 'Project Created',
            'description' => 'Project was created and submitted for approval',
            'type' => 'creation',
        ];

        // Status changes (would need to be tracked in a separate table)
        // For now, we'll just show current status
        $timeline[] = [
            'date' => $project->updated_at,
            'event' => 'Status: ' . ucfirst($project->status),
            'description' => "Project status is currently {$project->status}",
            'type' => 'status',
        ];

        // Publications
        foreach ($project->publications as $publication) {
            $timeline[] = [
                'date' => $publication->created_at,
                'event' => 'Publication Added',
                'description' => $publication->title,
                'type' => 'publication',
            ];
        }

        // Sort by date
        usort($timeline, function ($a, $b) {
            return $a['date']->timestamp - $b['date']->timestamp;
        });

        return $timeline;
    }
}