<?php

namespace App\Services;

use App\Models\Researcher;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ResearcherService
{
    public function __construct(
        private FileUploadService $fileUploadService,
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of researchers with filters.
     */
    public function getResearchers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Researcher::with(['user', 'ledProjects', 'publications']);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->byName($filters['search'])
                  ->orWhere('research_domain', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['domain'])) {
            $query->byDomain($filters['domain']);
        }

        if (!empty($filters['status'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        }

        return $query->orderBy('last_name')
                    ->orderBy('first_name')
                    ->paginate($perPage);
    }

    /**
     * Create a new researcher profile.
     */
    public function createResearcher(array $researcherData, ?UploadedFile $photo = null, ?UploadedFile $cv = null): Researcher
    {
        return DB::transaction(function () use ($researcherData, $photo, $cv) {
            // Handle file uploads
            if ($photo) {
                $researcherData['photo_path'] = $this->fileUploadService->uploadResearcherPhoto($photo);
            }

            if ($cv) {
                $researcherData['cv_path'] = $this->fileUploadService->uploadResearcherCV($cv);
            }

            // Create researcher
            $researcher = Researcher::create($researcherData);

            // Sync with ORCID if provided
            if (!empty($researcherData['orcid'])) {
                $this->syncWithOrcid($researcher);
            }

            // Notify admin of new researcher registration
            $this->notificationService->notifyAdminsOfNewResearcher($researcher);

            return $researcher->load('user');
        });
    }

    /**
     * Update researcher profile.
     */
    public function updateResearcher(Researcher $researcher, array $updateData, ?UploadedFile $photo = null, ?UploadedFile $cv = null): Researcher
    {
        return DB::transaction(function () use ($researcher, $updateData, $photo, $cv) {
            // Handle photo upload
            if ($photo) {
                // Delete old photo if exists
                if ($researcher->photo_path) {
                    $this->fileUploadService->deleteFile($researcher->photo_path);
                }
                $updateData['photo_path'] = $this->fileUploadService->uploadResearcherPhoto($photo);
            }

            // Handle CV upload
            if ($cv) {
                // Delete old CV if exists
                if ($researcher->cv_path) {
                    $this->fileUploadService->deleteFile($researcher->cv_path);
                }
                $updateData['cv_path'] = $this->fileUploadService->uploadResearcherCV($cv);
            }

            // Update researcher
            $researcher->update($updateData);

            // Auto-sync with ORCID if changed
            if (isset($updateData['orcid']) && $updateData['orcid'] !== $researcher->getOriginal('orcid')) {
                $this->syncWithOrcid($researcher);
            }

            return $researcher->fresh(['user']);
        });
    }

    /**
     * Get researcher profile with statistics.
     */
    public function getResearcherProfile(int $researcherId): array
    {
        $researcher = Researcher::with([
            'user',
            'ledProjects' => function ($query) {
                $query->withCount('members');
            },
            'publications' => function ($query) {
                $query->published()->orderBy('publication_year', 'desc');
            },
            'equipmentReservations' => function ($query) {
                $query->where('status', 'approved')->orderBy('start_datetime', 'desc');
            }
        ])->findOrFail($researcherId);

        $statistics = $this->getResearcherStatistics($researcher);

        return [
            'researcher' => $researcher,
            'statistics' => $statistics,
        ];
    }

    /**
     * Get researcher statistics.
     */
    public function getResearcherStatistics(Researcher $researcher): array
    {
        return [
            'total_projects' => $researcher->ledProjects()->count() + $researcher->projects()->count(),
            'active_projects' => $researcher->projects()->active()->count(),
            'total_publications' => $researcher->publications()->count(),
            'published_publications' => $researcher->publications()->published()->count(),
            'h_index' => $this->calculateHIndex($researcher),
            'total_citations' => $this->getTotalCitations($researcher),
            'recent_publications' => $researcher->publications()
                                               ->published()
                                               ->where('publication_year', '>=', now()->year - 5)
                                               ->count(),
            'equipment_reservations' => $researcher->equipmentReservations()->count(),
            'collaborations' => $researcher->coordinatedCollaborations()->count(),
        ];
    }

    /**
     * Search researchers by multiple criteria.
     */
    public function searchResearchers(string $query, array $filters = []): Collection
    {
        $searchQuery = Researcher::with(['user', 'ledProjects', 'publications'])
            ->where(function ($q) use ($query) {
                $q->byName($query)
                  ->orWhere('research_domain', 'like', '%' . $query . '%')
                  ->orWhere('bio_ar', 'like', '%' . $query . '%')
                  ->orWhere('bio_fr', 'like', '%' . $query . '%')
                  ->orWhere('bio_en', 'like', '%' . $query . '%');
            });

        // Apply additional filters
        if (!empty($filters['domain'])) {
            $searchQuery->byDomain($filters['domain']);
        }

        if (!empty($filters['has_orcid'])) {
            $searchQuery->whereHas('user', function ($q) {
                $q->whereNotNull('orcid');
            });
        }

        return $searchQuery->limit(50)->get();
    }

    /**
     * Get researchers by research domain.
     */
    public function getResearchersByDomain(string $domain): Collection
    {
        return Researcher::byDomain($domain)
                         ->with(['user', 'publications'])
                         ->get();
    }

    /**
     * Sync researcher data with ORCID.
     */
    public function syncWithOrcid(Researcher $researcher): bool
    {
        if (!$researcher->user->orcid) {
            return false;
        }

        try {
            // This would integrate with ORCID API
            // For now, we'll just log the sync attempt
            \Log::info("ORCID sync attempted for researcher {$researcher->id} with ORCID {$researcher->user->orcid}");

            // TODO: Implement actual ORCID API integration
            // $orcidData = $this->fetchFromOrcidApi($researcher->user->orcid);
            // $this->updateResearcherFromOrcid($researcher, $orcidData);

            return true;
        } catch (\Exception $e) {
            \Log::error("ORCID sync failed for researcher {$researcher->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get collaboration network for researcher.
     */
    public function getCollaborationNetwork(Researcher $researcher): array
    {
        // Get co-authors from publications
        $coAuthors = DB::table('publication_authors as pa1')
            ->join('publication_authors as pa2', 'pa1.publication_id', '=', 'pa2.publication_id')
            ->join('researchers as r', 'pa2.researcher_id', '=', 'r.id')
            ->join('users as u', 'r.user_id', '=', 'u.id')
            ->where('pa1.researcher_id', $researcher->id)
            ->where('pa2.researcher_id', '!=', $researcher->id)
            ->select('r.id', 'r.first_name', 'r.last_name', 'u.email', DB::raw('COUNT(*) as collaboration_count'))
            ->groupBy('r.id', 'r.first_name', 'r.last_name', 'u.email')
            ->orderBy('collaboration_count', 'desc')
            ->limit(20)
            ->get();

        // Get project collaborators
        $projectCollaborators = DB::table('project_members as pm1')
            ->join('project_members as pm2', 'pm1.project_id', '=', 'pm2.project_id')
            ->join('researchers as r', 'pm2.researcher_id', '=', 'r.id')
            ->join('users as u', 'r.user_id', '=', 'u.id')
            ->where('pm1.researcher_id', $researcher->id)
            ->where('pm2.researcher_id', '!=', $researcher->id)
            ->select('r.id', 'r.first_name', 'r.last_name', 'u.email', DB::raw('COUNT(DISTINCT pm1.project_id) as project_count'))
            ->groupBy('r.id', 'r.first_name', 'r.last_name', 'u.email')
            ->orderBy('project_count', 'desc')
            ->limit(20)
            ->get();

        return [
            'co_authors' => $coAuthors,
            'project_collaborators' => $projectCollaborators,
        ];
    }

    /**
     * Calculate H-index for researcher.
     */
    private function calculateHIndex(Researcher $researcher): int
    {
        // This would require citation data
        // For now, return a placeholder calculation based on publications
        $publicationCount = $researcher->publications()->published()->count();

        // Simplified H-index estimation
        return min($publicationCount, (int) sqrt($publicationCount * 5));
    }

    /**
     * Get total citations for researcher.
     */
    private function getTotalCitations(Researcher $researcher): int
    {
        // This would integrate with citation databases
        // For now, return a placeholder
        return $researcher->publications()->published()->count() * 3; // Simplified estimation
    }

    /**
     * Validate researcher profile data.
     */
    public function validateResearcherData(array $data): array
    {
        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'research_domain' => 'required|string|max:500',
            'google_scholar_url' => 'nullable|url|max:500',
            'bio_ar' => 'nullable|string|max:2000',
            'bio_fr' => 'nullable|string|max:2000',
            'bio_en' => 'nullable|string|max:2000',
        ];

        return \Validator::make($data, $rules)->validate();
    }

    /**
     * Generate researcher profile export data.
     */
    public function exportResearcherProfile(Researcher $researcher, string $format = 'json'): array
    {
        $data = [
            'personal_info' => [
                'name' => $researcher->full_name,
                'email' => $researcher->user->email,
                'orcid' => $researcher->user->orcid,
                'research_domain' => $researcher->research_domain,
                'google_scholar' => $researcher->google_scholar_url,
            ],
            'biography' => [
                'ar' => $researcher->bio_ar,
                'fr' => $researcher->bio_fr,
                'en' => $researcher->bio_en,
            ],
            'projects' => $researcher->ledProjects()->with('members')->get()->toArray(),
            'publications' => $researcher->publications()->published()->get()->toArray(),
            'statistics' => $this->getResearcherStatistics($researcher),
        ];

        return $data;
    }

    /**
     * Delete researcher profile.
     */
    public function deleteResearcher(Researcher $researcher): bool
    {
        return DB::transaction(function () use ($researcher) {
            // Delete associated files
            if ($researcher->photo_path) {
                $this->fileUploadService->deleteFile($researcher->photo_path);
            }

            if ($researcher->cv_path) {
                $this->fileUploadService->deleteFile($researcher->cv_path);
            }

            // Delete researcher record (user will be handled separately if needed)
            return $researcher->delete();
        });
    }

    /**
     * Get researcher projects with pagination
     */
    public function getResearcherProjects(Researcher $researcher, int $perPage = 15)
    {
        return $researcher->leadProjects()
            ->with(['members.researcher.user', 'funding'])
            ->orderBy('start_date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get researcher publications with pagination
     */
    public function getResearcherPublications(Researcher $researcher, int $perPage = 15)
    {
        return $researcher->publications()
            ->with(['authors.researcher.user'])
            ->orderBy('publication_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get researcher collaborations
     */
    public function getResearcherCollaborations(Researcher $researcher, int $perPage = 15)
    {
        return $researcher->coordinatedCollaborations()
            ->with(['participants.researcher.user', 'events'])
            ->orderBy('start_date', 'desc')
            ->paginate($perPage);
    }
}