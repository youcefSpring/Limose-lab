<?php

namespace App\Http\Requests\Publication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePublicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $publication = $this->route('publication');

        return auth()->check() && (
            auth()->user()->isAdmin() ||
            auth()->user()->isLabManager() ||
            (auth()->user()->isResearcher() &&
             $publication->authorResearchers()->where('researcher_id', auth()->user()->researcher->id)->exists())
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $publication = $this->route('publication');

        return [
            'title' => 'sometimes|required|string|max:500',
            'authors' => 'sometimes|required|string|max:1000',
            'journal' => 'nullable|string|max:255',
            'conference' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'doi' => [
                'nullable',
                'regex:/^10\.\d{4,}\/[-._;()\/:A-Za-z0-9]+$/',
                Rule::unique('publications')->ignore($publication->id ?? null)
            ],
            'publication_year' => [
                'sometimes',
                'required',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 5)
            ],
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'type' => ['sometimes', 'required', Rule::in(['article', 'conference', 'patent', 'book', 'poster'])],
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'status' => [
                'sometimes',
                Rule::in(['draft', 'submitted', 'published', 'archived'])
            ],
            'author_researchers' => 'nullable|array',
            'author_researchers.*.researcher_id' => 'required|exists:researchers,id',
            'author_researchers.*.author_order' => 'required|integer|min:1',
            'author_researchers.*.is_corresponding_author' => 'boolean',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'العنوان مطلوب.',
            'title.max' => 'العنوان لا يجب أن يتجاوز 500 حرف.',
            'authors.required' => 'المؤلفون مطلوبون.',
            'authors.max' => 'المؤلفون لا يجب أن يتجاوزوا 1000 حرف.',
            'journal.max' => 'اسم المجلة لا يجب أن يتجاوز 255 حرف.',
            'conference.max' => 'اسم المؤتمر لا يجب أن يتجاوز 255 حرف.',
            'publisher.max' => 'اسم الناشر لا يجب أن يتجاوز 255 حرف.',
            'doi.regex' => 'تنسيق DOI غير صالح.',
            'doi.unique' => 'DOI مستخدم من قبل.',
            'publication_year.required' => 'سنة النشر مطلوبة.',
            'publication_year.integer' => 'سنة النشر يجب أن تكون رقم صحيح.',
            'publication_year.min' => 'سنة النشر يجب أن تكون من 1900 أو أحدث.',
            'publication_year.max' => 'سنة النشر لا يمكن أن تكون في المستقبل البعيد.',
            'volume.max' => 'رقم المجلد لا يجب أن يتجاوز 50 حرف.',
            'issue.max' => 'رقم العدد لا يجب أن يتجاوز 50 حرف.',
            'pages.max' => 'الصفحات لا يجب أن تتجاوز 50 حرف.',
            'type.required' => 'نوع المنشور مطلوب.',
            'type.in' => 'نوع المنشور المحدد غير صالح.',
            'pdf_file.mimes' => 'ملف PDF يجب أن يكون من نوع PDF.',
            'pdf_file.max' => 'حجم ملف PDF لا يجب أن يتجاوز 10MB.',
            'status.in' => 'حالة المنشور المحددة غير صالحة.',
            'author_researchers.array' => 'المؤلفون الباحثون يجب أن يكون مصفوفة.',
            'author_researchers.*.researcher_id.required' => 'معرف الباحث مطلوب.',
            'author_researchers.*.researcher_id.exists' => 'الباحث المحدد غير موجود.',
            'author_researchers.*.author_order.required' => 'ترتيب المؤلف مطلوب.',
            'author_researchers.*.author_order.min' => 'ترتيب المؤلف يجب أن يكون 1 أو أكثر.',
            'author_researchers.*.is_corresponding_author.boolean' => 'الحقل يجب أن يكون صحيح أو خطأ.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'العنوان',
            'authors' => 'المؤلفون',
            'journal' => 'المجلة',
            'conference' => 'المؤتمر',
            'publisher' => 'الناشر',
            'doi' => 'DOI',
            'publication_year' => 'سنة النشر',
            'volume' => 'المجلد',
            'issue' => 'العدد',
            'pages' => 'الصفحات',
            'type' => 'النوع',
            'pdf_file' => 'ملف PDF',
            'status' => 'الحالة',
            'author_researchers' => 'المؤلفون الباحثون',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check if either journal or conference is provided based on type
            if ($this->has('type')) {
                if ($this->type === 'article' && empty($this->journal)) {
                    $validator->errors()->add('journal', 'المجلة مطلوبة للمقالات.');
                }

                if ($this->type === 'conference' && empty($this->conference)) {
                    $validator->errors()->add('conference', 'المؤتمر مطلوب لأوراق المؤتمرات.');
                }
            }

            // Validate that there's only one corresponding author
            if ($this->has('author_researchers')) {
                $correspondingAuthors = collect($this->author_researchers)
                    ->where('is_corresponding_author', true)
                    ->count();

                if ($correspondingAuthors > 1) {
                    $validator->errors()->add('author_researchers', 'يمكن تحديد مؤلف مراسل واحد فقط.');
                }
            }
        });
    }
}