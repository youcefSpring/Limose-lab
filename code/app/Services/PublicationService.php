<?php

namespace App\Services;

use App\Models\Publication;
use App\Models\PublicationAuthor;
use App\Models\Researcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PublicationService
{
    public function __construct(
        private FileUploadService $fileUploadService,
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of publications with filters.
     */
    public function getPublications(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Publication::with(['creator.user', 'authorResearchers']);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->byTitle($filters['search'])
                  ->orWhere('authors', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['type'])) {
            $query->byType($filters['type']);
        }

        if (!empty($filters['year'])) {
            $query->byYear($filters['year']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['author_id'])) {
            $query->whereHas('authorResearchers', function ($q) use ($filters) {
                $q->where('researcher_id', $filters['author_id']);
            });
        }

        return $query->orderBy('publication_year', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Create a new publication.
     */
    public function createPublication(array $publicationData, Researcher $creator, ?UploadedFile $pdfFile = null): Publication
    {
        return DB::transaction(function () use ($publicationData, $creator, $pdfFile) {
            // Handle PDF upload
            if ($pdfFile) {
                $publicationData['pdf_path'] = $this->fileUploadService->uploadPublicationPDF($pdfFile);
            }

            // Create publication
            $publication = Publication::create([
                'title' => $publicationData['title'],
                'authors' => $publicationData['authors'],
                'journal' => $publicationData['journal'] ?? null,
                'conference' => $publicationData['conference'] ?? null,
                'publisher' => $publicationData['publisher'] ?? null,
                'doi' => $publicationData['doi'] ?? null,
                'publication_year' => $publicationData['publication_year'],
                'volume' => $publicationData['volume'] ?? null,
                'issue' => $publicationData['issue'] ?? null,
                'pages' => $publicationData['pages'] ?? null,
                'type' => $publicationData['type'],
                'pdf_path' => $publicationData['pdf_path'] ?? null,
                'status' => 'draft',
                'created_by' => $creator->id,
            ]);

            // Add authors
            if (!empty($publicationData['author_researchers'])) {
                $this->addPublicationAuthors($publication, $publicationData['author_researchers']);
            }

            // Link to projects if specified
            if (!empty($publicationData['project_ids'])) {
                $publication->projects()->attach($publicationData['project_ids']);
            }

            return $publication->load(['authorResearchers', 'projects']);
        });
    }

    /**
     * Import publication from DOI.
     */
    public function importFromDOI(string $doi, Researcher $creator): Publication
    {
        try {
            // Fetch publication data from CrossRef
            $publicationData = $this->fetchPublicationFromDOI($doi);

            return $this->createPublication($publicationData, $creator);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'doi' => ['فشل في استيراد المنشور من DOI: ' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Import publication from BibTeX.
     */
    public function importFromBibTeX(string $bibtexContent, Researcher $creator): Publication
    {
        try {
            $publicationData = $this->parseBibTeX($bibtexContent);

            return $this->createPublication($publicationData, $creator);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'bibtex' => ['فشل في استيراد المنشور من BibTeX: ' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Update publication.
     */
    public function updatePublication(Publication $publication, array $updateData, ?UploadedFile $pdfFile = null): Publication
    {
        return DB::transaction(function () use ($publication, $updateData, $pdfFile) {
            // Handle PDF upload
            if ($pdfFile) {
                // Delete old PDF if exists
                if ($publication->pdf_path) {
                    $this->fileUploadService->deleteFile($publication->pdf_path);
                }
                $updateData['pdf_path'] = $this->fileUploadService->uploadPublicationPDF($pdfFile);
            }

            // Update publication
            $publication->update($updateData);

            // Update authors if provided
            if (isset($updateData['author_researchers'])) {
                $this->updatePublicationAuthors($publication, $updateData['author_researchers']);
            }

            // Update project links if provided
            if (isset($updateData['project_ids'])) {
                $publication->projects()->sync($updateData['project_ids']);
            }

            return $publication->fresh(['authorResearchers', 'projects']);
        });
    }

    /**
     * Change publication status.
     */
    public function changePublicationStatus(Publication $publication, string $newStatus): Publication
    {
        $this->validateStatusTransition($publication->status, $newStatus);

        $publication->update(['status' => $newStatus]);

        // Notify co-authors of status change
        if ($newStatus === 'published') {
            $this->notificationService->notifyPublicationPublished($publication);
        }

        return $publication;
    }

    /**
     * Add authors to publication.
     */
    public function addPublicationAuthors(Publication $publication, array $authors): void
    {
        foreach ($authors as $authorData) {
            PublicationAuthor::create([
                'publication_id' => $publication->id,
                'researcher_id' => $authorData['researcher_id'],
                'author_order' => $authorData['author_order'],
                'is_corresponding_author' => $authorData['is_corresponding_author'] ?? false,
            ]);
        }
    }

    /**
     * Update publication authors.
     */
    public function updatePublicationAuthors(Publication $publication, array $authors): void
    {
        // Remove existing authors
        $publication->publicationAuthors()->delete();

        // Add new authors
        $this->addPublicationAuthors($publication, $authors);
    }

    /**
     * Generate publication statistics.
     */
    public function getPublicationStatistics(array $filters = []): array
    {
        $query = Publication::query();

        // Apply filters
        if (!empty($filters['year_from'])) {
            $query->where('publication_year', '>=', $filters['year_from']);
        }

        if (!empty($filters['year_to'])) {
            $query->where('publication_year', '<=', $filters['year_to']);
        }

        if (!empty($filters['researcher_id'])) {
            $query->whereHas('authorResearchers', function ($q) use ($filters) {
                $q->where('researcher_id', $filters['researcher_id']);
            });
        }

        return [
            'total_publications' => $query->count(),
            'published_publications' => $query->published()->count(),
            'by_type' => $query->selectRaw('type, COUNT(*) as count')
                              ->groupBy('type')
                              ->pluck('count', 'type')
                              ->toArray(),
            'by_year' => $query->selectRaw('publication_year, COUNT(*) as count')
                             ->groupBy('publication_year')
                             ->orderBy('publication_year', 'desc')
                             ->pluck('count', 'publication_year')
                             ->toArray(),
            'recent_publications' => $query->published()
                                          ->where('publication_year', '>=', now()->year - 5)
                                          ->count(),
        ];
    }

    /**
     * Export publications to BibTeX format.
     */
    public function exportToBibTeX(array $publicationIds): string
    {
        $publications = Publication::whereIn('id', $publicationIds)->get();
        $bibtex = '';

        foreach ($publications as $publication) {
            $bibtex .= $this->generateBibTeXEntry($publication) . "\n\n";
        }

        return $bibtex;
    }

    /**
     * Search publications with full-text search.
     */
    public function searchPublications(string $query, array $filters = []): Collection
    {
        $searchQuery = Publication::with(['authorResearchers'])
            ->where(function ($q) use ($query) {
                $q->byTitle($query)
                  ->orByAuthor($query);
            });

        // Apply filters
        if (!empty($filters['type'])) {
            $searchQuery->byType($filters['type']);
        }

        if (!empty($filters['year'])) {
            $searchQuery->byYear($filters['year']);
        }

        return $searchQuery->published()->limit(50)->get();
    }

    /**
     * Get researcher's publication metrics.
     */
    public function getResearcherMetrics(Researcher $researcher): array
    {
        $publications = $researcher->publications()->published();

        return [
            'total_publications' => $publications->count(),
            'first_author_publications' => $researcher->publicationAuthors()
                                                     ->where('author_order', 1)
                                                     ->count(),
            'corresponding_author_publications' => $researcher->publicationAuthors()
                                                             ->where('is_corresponding_author', true)
                                                             ->count(),
            'publications_by_type' => $publications->selectRaw('type, COUNT(*) as count')
                                                   ->groupBy('type')
                                                   ->pluck('count', 'type')
                                                   ->toArray(),
            'publications_by_year' => $publications->selectRaw('publication_year, COUNT(*) as count')
                                                   ->groupBy('publication_year')
                                                   ->orderBy('publication_year', 'desc')
                                                   ->pluck('count', 'publication_year')
                                                   ->toArray(),
            'recent_publications' => $publications->where('publication_year', '>=', now()->year - 5)
                                                  ->count(),
        ];
    }

    /**
     * Fetch publication data from DOI via CrossRef API.
     */
    private function fetchPublicationFromDOI(string $doi): array
    {
        $response = Http::get("https://api.crossref.org/works/{$doi}");

        if (!$response->successful()) {
            throw new \Exception('DOI not found or CrossRef API unavailable');
        }

        $data = $response->json()['message'];

        return [
            'title' => $data['title'][0] ?? 'Unknown Title',
            'authors' => $this->formatAuthorsFromCrossRef($data['author'] ?? []),
            'journal' => $data['container-title'][0] ?? null,
            'publisher' => $data['publisher'] ?? null,
            'doi' => $doi,
            'publication_year' => $data['published-print']['date-parts'][0][0] ??
                                 $data['published-online']['date-parts'][0][0] ??
                                 now()->year,
            'volume' => $data['volume'] ?? null,
            'issue' => $data['issue'] ?? null,
            'pages' => $data['page'] ?? null,
            'type' => 'article', // Default to article
        ];
    }

    /**
     * Format authors from CrossRef API response.
     */
    private function formatAuthorsFromCrossRef(array $authors): string
    {
        $formattedAuthors = [];

        foreach ($authors as $author) {
            $name = trim(($author['given'] ?? '') . ' ' . ($author['family'] ?? ''));
            if (!empty($name)) {
                $formattedAuthors[] = $name;
            }
        }

        return implode(', ', $formattedAuthors);
    }

    /**
     * Parse BibTeX content.
     */
    private function parseBibTeX(string $bibtexContent): array
    {
        // Simple BibTeX parser - in production, you'd want a more robust parser
        $data = [];

        // Extract title
        if (preg_match('/title\s*=\s*["{](.*?)["}]/i', $bibtexContent, $matches)) {
            $data['title'] = trim($matches[1]);
        }

        // Extract authors
        if (preg_match('/author\s*=\s*["{](.*?)["}]/i', $bibtexContent, $matches)) {
            $data['authors'] = trim($matches[1]);
        }

        // Extract journal
        if (preg_match('/journal\s*=\s*["{](.*?)["}]/i', $bibtexContent, $matches)) {
            $data['journal'] = trim($matches[1]);
        }

        // Extract year
        if (preg_match('/year\s*=\s*["{]?(\d{4})["}]?/i', $bibtexContent, $matches)) {
            $data['publication_year'] = (int) $matches[1];
        }

        // Extract DOI
        if (preg_match('/doi\s*=\s*["{](.*?)["}]/i', $bibtexContent, $matches)) {
            $data['doi'] = trim($matches[1]);
        }

        // Extract volume
        if (preg_match('/volume\s*=\s*["{](.*?)["}]/i', $bibtexContent, $matches)) {
            $data['volume'] = trim($matches[1]);
        }

        // Extract pages
        if (preg_match('/pages\s*=\s*["{](.*?)["}]/i', $bibtexContent, $matches)) {
            $data['pages'] = trim($matches[1]);
        }

        // Determine type from entry type
        if (preg_match('/@(\w+)\s*{/i', $bibtexContent, $matches)) {
            $entryType = strtolower($matches[1]);
            $data['type'] = match ($entryType) {
                'article' => 'article',
                'inproceedings', 'conference' => 'conference',
                'book' => 'book',
                default => 'article'
            };
        } else {
            $data['type'] = 'article';
        }

        return $data;
    }

    /**
     * Generate BibTeX entry for publication.
     */
    private function generateBibTeXEntry(Publication $publication): string
    {
        $key = strtolower(str_replace(' ', '', $publication->title));
        $key = preg_replace('/[^a-z0-9]/', '', $key);
        $key = substr($key, 0, 20) . $publication->publication_year;

        $bibtex = "@{$publication->type}{{$key},\n";
        $bibtex .= "  title = {{$publication->title}},\n";
        $bibtex .= "  author = {{$publication->authors}},\n";

        if ($publication->journal) {
            $bibtex .= "  journal = {{$publication->journal}},\n";
        }

        if ($publication->conference) {
            $bibtex .= "  booktitle = {{$publication->conference}},\n";
        }

        if ($publication->publisher) {
            $bibtex .= "  publisher = {{$publication->publisher}},\n";
        }

        $bibtex .= "  year = {{$publication->publication_year}},\n";

        if ($publication->volume) {
            $bibtex .= "  volume = {{$publication->volume}},\n";
        }

        if ($publication->issue) {
            $bibtex .= "  number = {{$publication->issue}},\n";
        }

        if ($publication->pages) {
            $bibtex .= "  pages = {{$publication->pages}},\n";
        }

        if ($publication->doi) {
            $bibtex .= "  doi = {{$publication->doi}},\n";
        }

        $bibtex .= "}";

        return $bibtex;
    }

    /**
     * Validate publication status transition.
     */
    private function validateStatusTransition(string $currentStatus, string $newStatus): void
    {
        $allowedTransitions = [
            'draft' => ['submitted', 'published'],
            'submitted' => ['published', 'draft'],
            'published' => ['archived'],
            'archived' => [], // No transitions from archived
        ];

        if (!isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            throw ValidationException::withMessages([
                'status' => ["لا يمكن تغيير حالة المنشور من {$currentStatus} إلى {$newStatus}"],
            ]);
        }
    }
}