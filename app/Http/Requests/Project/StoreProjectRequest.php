<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isResearcher();
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
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'budget' => 'required|numeric|min:0|max:999999999.99',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'member_ids' => 'nullable|array',
            'member_ids.*' => 'exists:researchers,id',
            'leader_id' => 'required|exists:researchers,id',
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
            'description_ar.max' => 'الوصف (عربي) لا يجب أن يتجاوز 2000 حرف.',
            'description_fr.max' => 'الوصف (فرنسي) لا يجب أن يتجاوز 2000 حرف.',
            'description_en.max' => 'الوصف (إنجليزي) لا يجب أن يتجاوز 2000 حرف.',
            'budget.required' => 'الميزانية مطلوبة.',
            'budget.numeric' => 'الميزانية يجب أن تكون رقم.',
            'budget.min' => 'الميزانية يجب أن تكون أكبر من أو تساوي 0.',
            'budget.max' => 'الميزانية تتجاوز الحد الأقصى المسموح.',
            'start_date.required' => 'تاريخ البداية مطلوب.',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخ صالح.',
            'start_date.after' => 'تاريخ البداية يجب أن يكون في المستقبل.',
            'end_date.required' => 'تاريخ الانتهاء مطلوب.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخ صالح.',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية.',
            'member_ids.array' => 'أعضاء الفريق يجب أن يكون مصفوفة.',
            'member_ids.*.exists' => 'أحد أعضاء الفريق المحددين غير موجود.',
            'leader_id.required' => 'قائد المشروع مطلوب.',
            'leader_id.exists' => 'قائد المشروع المحدد غير موجود.',
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
            'description_ar' => 'الوصف (عربي)',
            'description_fr' => 'الوصف (فرنسي)',
            'description_en' => 'الوصف (إنجليزي)',
            'budget' => 'الميزانية',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ الانتهاء',
            'member_ids' => 'أعضاء الفريق',
            'leader_id' => 'قائد المشروع',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set the current user as project leader if not specified
        if (!$this->has('leader_id') && auth()->user()->researcher) {
            $this->merge(['leader_id' => auth()->user()->researcher->id]);
        }
    }
}