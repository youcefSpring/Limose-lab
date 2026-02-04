<?php

namespace App\Http\Requests;

use App\Models\Publication;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $publication = $this->route('publication');
        return $this->user()->can('update', $publication);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'abstract' => 'nullable|string',
            'abstract_fr' => 'nullable|string',
            'abstract_ar' => 'nullable|string',
            'authors' => 'required|string',
            'journal' => 'nullable|string|max:255',
            'conference' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'url' => 'nullable|url|max:255',
            'pdf_file' => [
                'nullable',
                'file',
                'mimes:pdf',  // Restricted to PDF only for security
                'max:10240',  // 10MB max
            ],
            'type' => 'required|in:journal,conference,book,chapter,thesis,preprint,other',
            'status' => 'required|in:published,in_press,submitted,draft',
            'publication_date' => 'nullable|date',
            'keywords' => 'nullable|string',
            'research_areas' => 'nullable|string',
            'is_open_access' => 'boolean',
            'citations_count' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => __('The publication title is required.'),
            'title.max' => __('The publication title may not be greater than 255 characters.'),
            'authors.required' => __('At least one author is required.'),
            'year.required' => __('The publication year is required.'),
            'year.min' => __('The year must be 1900 or later.'),
            'year.max' => __('The year cannot be more than 5 years in the future.'),
            'pdf_file.mimes' => __('Only PDF files are allowed for security reasons.'),
            'pdf_file.max' => __('The PDF file may not be larger than 10MB.'),
            'type.required' => __('Please select a publication type.'),
            'type.in' => __('The selected publication type is invalid.'),
            'status.required' => __('Please select a publication status.'),
            'status.in' => __('The selected publication status is invalid.'),
            'url.url' => __('Please enter a valid URL.'),
        ];
    }
}
