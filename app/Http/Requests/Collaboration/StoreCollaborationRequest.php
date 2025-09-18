<?php

namespace App\Http\Requests\Collaboration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCollaborationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (
            auth()->user()->isAdmin() ||
            auth()->user()->isLabManager() ||
            auth()->user()->isResearcher()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'type' => ['required', Rule::in(['academic', 'industrial', 'governmental', 'international', 'other'])],
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'coordinator_id' => 'required|exists:researchers,id',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title_ar.required' => 'العنوان (عربي) مطلوب.',
            'title_ar.max' => 'العنوان (عربي) لا يجب أن يتجاوز 255 حرف.',
            'title_fr.required' => 'العنوان (فرنسي) مطلوب.',
            'title_fr.max' => 'العنوان (فرنسي) لا يجب أن يتجاوز 255 حرف.',
            'title_en.required' => 'العنوان (إنجليزي) مطلوب.',
            'title_en.max' => 'العنوان (إنجليزي) لا يجب أن يتجاوز 255 حرف.',
            'institution_name.required' => 'اسم المؤسسة مطلوب.',
            'institution_name.max' => 'اسم المؤسسة لا يجب أن يتجاوز 255 حرف.',
            'country.required' => 'البلد مطلوب.',
            'country.max' => 'البلد لا يجب أن يتجاوز 100 حرف.',
            'contact_person.max' => 'الشخص المسؤول لا يجب أن يتجاوز 255 حرف.',
            'contact_email.email' => 'البريد الإلكتروني للمسؤول يجب أن يكون صالح.',
            'contact_email.max' => 'البريد الإلكتروني للمسؤول لا يجب أن يتجاوز 255 حرف.',
            'start_date.required' => 'تاريخ البداية مطلوب.',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخ صالح.',
            'start_date.after_or_equal' => 'تاريخ البداية يجب أن يكون اليوم أو في المستقبل.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخ صالح.',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية.',
            'type.required' => 'نوع التعاون مطلوب.',
            'type.in' => 'نوع التعاون المحدد غير صالح.',
            'description_ar.max' => 'الوصف (عربي) لا يجب أن يتجاوز 2000 حرف.',
            'description_fr.max' => 'الوصف (فرنسي) لا يجب أن يتجاوز 2000 حرف.',
            'description_en.max' => 'الوصف (إنجليزي) لا يجب أن يتجاوز 2000 حرف.',
            'coordinator_id.required' => 'المنسق مطلوب.',
            'coordinator_id.exists' => 'المنسق المحدد غير موجود.',
            'document.mimes' => 'الوثيقة يجب أن تكون من نوع: PDF, DOC, DOCX.',
            'document.max' => 'حجم الوثيقة لا يجب أن يتجاوز 10MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title_ar' => 'العنوان (عربي)',
            'title_fr' => 'العنوان (فرنسي)',
            'title_en' => 'العنوان (إنجليزي)',
            'institution_name' => 'اسم المؤسسة',
            'country' => 'البلد',
            'contact_person' => 'الشخص المسؤول',
            'contact_email' => 'البريد الإلكتروني للمسؤول',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ الانتهاء',
            'type' => 'النوع',
            'description_ar' => 'الوصف (عربي)',
            'description_fr' => 'الوصف (فرنسي)',
            'description_en' => 'الوصف (إنجليزي)',
            'coordinator_id' => 'المنسق',
            'document' => 'الوثيقة',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set coordinator to current user's researcher if not specified and user is researcher
        if (!$this->has('coordinator_id') && auth()->user()->isResearcher()) {
            $this->merge(['coordinator_id' => auth()->user()->researcher->id]);
        }
    }
}