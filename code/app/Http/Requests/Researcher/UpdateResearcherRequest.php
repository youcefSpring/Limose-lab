<?php

namespace App\Http\Requests\Researcher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResearcherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $researcher = $this->route('researcher');

        return auth()->check() && (
            auth()->user()->isAdmin() ||
            auth()->user()->isLabManager() ||
            (auth()->user()->isResearcher() && auth()->user()->researcher->id === $researcher->id)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'research_domain' => 'required|string|max:500',
            'google_scholar_url' => 'nullable|url|max:500',
            'bio_ar' => 'nullable|string|max:2000',
            'bio_fr' => 'nullable|string|max:2000',
            'bio_en' => 'nullable|string|max:2000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv_file' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.max' => 'الاسم الأول لا يجب أن يتجاوز 100 حرف.',
            'last_name.required' => 'اسم العائلة مطلوب.',
            'last_name.max' => 'اسم العائلة لا يجب أن يتجاوز 100 حرف.',
            'research_domain.required' => 'مجال البحث مطلوب.',
            'research_domain.max' => 'مجال البحث لا يجب أن يتجاوز 500 حرف.',
            'google_scholar_url.url' => 'رابط Google Scholar غير صالح.',
            'bio_ar.max' => 'السيرة الذاتية (عربي) لا يجب أن تتجاوز 2000 حرف.',
            'bio_fr.max' => 'السيرة الذاتية (فرنسي) لا يجب أن تتجاوز 2000 حرف.',
            'bio_en.max' => 'السيرة الذاتية (إنجليزي) لا يجب أن تتجاوز 2000 حرف.',
            'photo.image' => 'الصورة يجب أن تكون ملف صورة.',
            'photo.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg.',
            'photo.max' => 'حجم الصورة لا يجب أن يتجاوز 2MB.',
            'cv_file.mimes' => 'ملف السيرة الذاتية يجب أن يكون PDF.',
            'cv_file.max' => 'حجم ملف السيرة الذاتية لا يجب أن يتجاوز 5MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'الاسم الأول',
            'last_name' => 'اسم العائلة',
            'research_domain' => 'مجال البحث',
            'google_scholar_url' => 'رابط Google Scholar',
            'bio_ar' => 'السيرة الذاتية (عربي)',
            'bio_fr' => 'السيرة الذاتية (فرنسي)',
            'bio_en' => 'السيرة الذاتية (إنجليزي)',
            'photo' => 'الصورة',
            'cv_file' => 'ملف السيرة الذاتية',
        ];
    }
}