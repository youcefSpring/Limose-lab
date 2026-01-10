<?php

namespace App\Services;

use App\Models\Experiment;
use App\Models\ExperimentFile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExperimentService
{
    /**
     * Configuration constants
     */
    const MAX_FILES_PER_EXPERIMENT = 5;
    const MAX_FILE_SIZE_MB = 10;
    const MAX_FILE_SIZE_BYTES = self::MAX_FILE_SIZE_MB * 1024 * 1024;

    /**
     * Create a new experiment with optional file uploads.
     *
     * @param User $user
     * @param array $data
     * @return array
     */
    public function createExperiment(User $user, array $data): array
    {
        // Validate project exists and user is a member
        $project = Project::find($data['project_id']);

        if (!$project) {
            return $this->errorResponse('Project not found');
        }

        if (!$project->hasMember($user)) {
            return $this->errorResponse('You must be a project member to add experiments');
        }

        // Validate files if provided
        if (isset($data['files']) && is_array($data['files'])) {
            if (count($data['files']) > self::MAX_FILES_PER_EXPERIMENT) {
                return $this->errorResponse('Maximum ' . self::MAX_FILES_PER_EXPERIMENT . ' files allowed per experiment');
            }

            foreach ($data['files'] as $file) {
                if ($file->getSize() > self::MAX_FILE_SIZE_BYTES) {
                    return $this->errorResponse('File size cannot exceed ' . self::MAX_FILE_SIZE_MB . 'MB');
                }
            }
        }

        try {
            $experiment = DB::transaction(function () use ($user, $data) {
                // Create experiment
                $experiment = Experiment::create([
                    'project_id' => $data['project_id'],
                    'user_id' => $user->id,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'experiment_type' => $data['experiment_type'] ?? null,
                    'experiment_date' => $data['experiment_date'] ?? now(),
                ]);

                // Upload files if provided
                if (isset($data['files']) && is_array($data['files'])) {
                    foreach ($data['files'] as $file) {
                        $this->uploadExperimentFile($experiment, $file);
                    }
                }

                return $experiment->fresh(['files', 'user', 'project']);
            });

            return [
                'success' => true,
                'experiment' => $experiment,
                'message' => 'Experiment created successfully',
            ];
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create experiment: ' . $e->getMessage());
        }
    }

    /**
     * Update an experiment.
     *
     * @param Experiment $experiment
     * @param array $data
     * @return Experiment
     */
    public function updateExperiment(Experiment $experiment, array $data): Experiment
    {
        $experiment->update([
            'title' => $data['title'] ?? $experiment->title,
            'description' => $data['description'] ?? $experiment->description,
            'experiment_type' => $data['experiment_type'] ?? $experiment->experiment_type,
            'experiment_date' => $data['experiment_date'] ?? $experiment->experiment_date,
        ]);

        return $experiment->fresh();
    }

    /**
     * Delete an experiment.
     *
     * @param Experiment $experiment
     * @return bool
     */
    public function deleteExperiment(Experiment $experiment): bool
    {
        // Delete all associated files
        foreach ($experiment->files as $file) {
            $this->deleteExperimentFile($file);
        }

        return $experiment->delete();
    }

    /**
     * Upload a file for an experiment.
     *
     * @param Experiment $experiment
     * @param \Illuminate\Http\UploadedFile $file
     * @return ExperimentFile
     */
    public function uploadExperimentFile(Experiment $experiment, $file): ExperimentFile
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->store('experiments', 'public');

        return ExperimentFile::create([
            'experiment_id' => $experiment->id,
            'file_name' => $originalName,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);
    }

    /**
     * Delete an experiment file.
     *
     * @param ExperimentFile $file
     * @return bool
     */
    public function deleteExperimentFile(ExperimentFile $file): bool
    {
        // Delete file from storage
        Storage::disk('public')->delete($file->file_path);

        // Delete database record
        return $file->delete();
    }

    /**
     * Add a comment to an experiment.
     *
     * @param Experiment $experiment
     * @param User $user
     * @param string $comment
     * @param int|null $parentId
     * @return array
     */
    public function addComment(Experiment $experiment, User $user, string $comment, ?int $parentId = null): array
    {
        // Verify user is a project member
        if (!$experiment->project->hasMember($user)) {
            return $this->errorResponse('You must be a project member to comment');
        }

        try {
            $experimentComment = $experiment->comments()->create([
                'user_id' => $user->id,
                'parent_id' => $parentId,
                'comment' => $comment,
            ]);

            return [
                'success' => true,
                'comment' => $experimentComment->fresh(['user', 'replies']),
                'message' => 'Comment added successfully',
            ];
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to add comment: ' . $e->getMessage());
        }
    }

    /**
     * Delete a comment.
     *
     * @param int $commentId
     * @param User $user
     * @return array
     */
    public function deleteComment(int $commentId, User $user): array
    {
        $comment = \App\Models\ExperimentComment::find($commentId);

        if (!$comment) {
            return $this->errorResponse('Comment not found');
        }

        // Only comment owner or admin can delete
        if ($comment->user_id !== $user->id && !$user->hasRole('admin')) {
            return $this->errorResponse('You are not authorized to delete this comment');
        }

        $comment->delete();

        return [
            'success' => true,
            'message' => 'Comment deleted successfully',
        ];
    }

    /**
     * Get experiments by project.
     *
     * @param int $projectId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProjectExperiments(int $projectId)
    {
        return Experiment::where('project_id', $projectId)
            ->with('user', 'files', 'comments.user')
            ->orderBy('experiment_date', 'desc')
            ->get();
    }

    /**
     * Get experiments by user.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserExperiments(User $user)
    {
        return Experiment::where('user_id', $user->id)
            ->with('project', 'files')
            ->orderBy('experiment_date', 'desc')
            ->get();
    }

    /**
     * Search experiments by keyword.
     *
     * @param string $keyword
     * @param int|null $projectId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchExperiments(string $keyword, ?int $projectId = null)
    {
        $query = Experiment::where('title', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%");

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        return $query->with('user', 'project', 'files')
            ->orderBy('experiment_date', 'desc')
            ->get();
    }

    /**
     * Helper method to format error response.
     *
     * @param string $message
     * @return array
     */
    private function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'experiment' => null,
            'errors' => [$message],
        ];
    }
}
