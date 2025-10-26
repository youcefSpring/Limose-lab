<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use Illuminate\Http\Request;

class ContentBlockController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ContentBlock::class);

        $contentBlocks = ContentBlock::orderBy('page')->orderBy('section')->orderBy('order')->paginate(20);

        return view('admin.content-blocks.index', compact('contentBlocks'));
    }

    public function create()
    {
        $this->authorize('create', ContentBlock::class);

        return view('admin.content-blocks.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', ContentBlock::class);

        $request->validate([
            'key' => 'required|string|max:255|unique:content_blocks',
            'title_en' => 'nullable|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_fr' => 'nullable|string',
            'content_ar' => 'nullable|string',
            'type' => 'required|string|in:text,html,image,video',
            'page' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        ContentBlock::create($request->all());

        return redirect()->route('admin.content-blocks.index')
            ->with('success', __('Content block created successfully.'));
    }

    public function show(ContentBlock $contentBlock)
    {
        $this->authorize('view', $contentBlock);

        return view('admin.content-blocks.show', compact('contentBlock'));
    }

    public function edit(ContentBlock $contentBlock)
    {
        $this->authorize('update', $contentBlock);

        return view('admin.content-blocks.edit', compact('contentBlock'));
    }

    public function update(Request $request, ContentBlock $contentBlock)
    {
        $this->authorize('update', $contentBlock);

        $request->validate([
            'key' => 'required|string|max:255|unique:content_blocks,key,' . $contentBlock->id,
            'title_en' => 'nullable|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_fr' => 'nullable|string',
            'content_ar' => 'nullable|string',
            'type' => 'required|string|in:text,html,image,video',
            'page' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $contentBlock->update($request->all());

        return redirect()->route('admin.content-blocks.index')
            ->with('success', __('Content block updated successfully.'));
    }

    public function destroy(ContentBlock $contentBlock)
    {
        $this->authorize('delete', $contentBlock);

        $contentBlock->delete();

        return redirect()->route('admin.content-blocks.index')
            ->with('success', __('Content block deleted successfully.'));
    }
}
