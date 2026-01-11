<?php

/**
 * File Viewer Component - Example Routes
 *
 * Add these routes to your routes/web.php file to enable demo and testing pages
 */

use Illuminate\Support\Facades\Route;

// Demo route - shows all component variations
Route::get('/demo/file-viewer', function () {
    return view('components.file-viewer-demo');
})->name('file-viewer.demo');

// Test route - single image
Route::get('/test/file-viewer/image', function () {
    return view('file-viewer-test', [
        'type' => 'image',
        'files' => 'storage/demo/sample-image.jpg',
        'title' => 'Single Image Test',
    ]);
})->name('file-viewer.test.image');

// Test route - multiple images
Route::get('/test/file-viewer/gallery', function () {
    return view('file-viewer-test', [
        'type' => 'image',
        'files' => [
            'storage/demo/image1.jpg',
            'storage/demo/image2.jpg',
            'storage/demo/image3.jpg',
            'storage/demo/image4.jpg',
        ],
        'title' => 'Image Gallery Test',
    ]);
})->name('file-viewer.test.gallery');

// Test route - PDF
Route::get('/test/file-viewer/pdf', function () {
    return view('file-viewer-test', [
        'type' => 'pdf',
        'files' => 'storage/demo/sample-document.pdf',
        'title' => 'PDF Document Test',
    ]);
})->name('file-viewer.test.pdf');

// Test route - Document
Route::get('/test/file-viewer/document', function () {
    return view('file-viewer-test', [
        'type' => 'document',
        'files' => 'storage/demo/sample-document.docx',
        'title' => 'Document Test',
    ]);
})->name('file-viewer.test.document');

/**
 * Example Publication Routes with File Viewer
 */
Route::middleware(['auth'])->group(function () {

    // Show publication with images and PDF
    Route::get('/publications/{publication}', function ($id) {
        // In real application, use controller:
        // return app(PublicationController::class)->show($publication);

        // Mock data for demonstration
        $publication = (object) [
            'id' => $id,
            'title' => 'Advanced Materials Research Study 2026',
            'abstract' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            'images' => [
                'storage/publications/pub-' . $id . '-img1.jpg',
                'storage/publications/pub-' . $id . '-img2.jpg',
                'storage/publications/pub-' . $id . '-img3.jpg',
            ],
            'pdf_file' => 'storage/publications/pub-' . $id . '.pdf',
        ];

        return view('publications.show', compact('publication'));
    })->name('publications.show');

});

/**
 * Example Event Routes with File Viewer
 */
Route::middleware(['auth'])->group(function () {

    // Show event with gallery
    Route::get('/events/{event}', function ($id) {
        // Mock data for demonstration
        $event = (object) [
            'id' => $id,
            'title' => 'Annual Research Symposium 2026',
            'description' => 'Lorem ipsum dolor sit amet...',
            'images' => [
                'storage/events/event-' . $id . '-img1.jpg',
                'storage/events/event-' . $id . '-img2.jpg',
                'storage/events/event-' . $id . '-img3.jpg',
                'storage/events/event-' . $id . '-img4.jpg',
                'storage/events/event-' . $id . '-img5.jpg',
            ],
            'poster' => 'storage/events/event-' . $id . '-poster.jpg',
            'date' => '2026-03-15',
        ];

        return view('events.show', compact('event'));
    })->name('events.show');

});

/**
 * Example Project Routes with File Viewer
 */
Route::middleware(['auth'])->group(function () {

    // Show project with documentation
    Route::get('/projects/{project}', function ($id) {
        // Mock data for demonstration
        $project = (object) [
            'id' => $id,
            'title' => 'Quantum Computing Research Initiative',
            'description' => 'Lorem ipsum dolor sit amet...',
            'images' => [
                'storage/projects/project-' . $id . '-img1.jpg',
                'storage/projects/project-' . $id . '-img2.jpg',
            ],
            'documents' => [
                'storage/projects/project-' . $id . '-proposal.pdf',
                'storage/projects/project-' . $id . '-report.pdf',
            ],
            'status' => 'active',
        ];

        return view('projects.show', compact('project'));
    })->name('projects.show');

});

/**
 * Example Material Routes with File Viewer
 */
Route::middleware(['auth'])->group(function () {

    // Show material with image
    Route::get('/materials/{material}', function ($id) {
        // Mock data for demonstration
        $material = (object) [
            'id' => $id,
            'name' => 'Oscilloscope - Tektronix MSO64',
            'description' => 'High-performance mixed signal oscilloscope...',
            'image' => 'storage/materials/material-' . $id . '.jpg',
            'manual' => 'storage/materials/material-' . $id . '-manual.pdf',
            'category' => 'Electronics',
            'status' => 'available',
        ];

        return view('materials.show', compact('material'));
    })->name('materials.show');

});
