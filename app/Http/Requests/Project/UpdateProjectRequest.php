<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = $this->route('project');

        return auth()->check() && (
            auth()->user()->isAdmin() ||
            auth()->user()->isLabManager() ||
            (auth()->user()->isResearcher() && auth()->user()->researcher->id === $project->leader_id)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $project = $this->route('project');

        return [
            'title_ar' => 'sometimes|required|string|max:255',
            'title_fr' => 'sometimes|required|string|max:255',
            'title_en' => 'sometimes|required|string|max:255',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'budget' => 'sometimes|required|numeric|min:0|max:999999999.99',
            'start_date' => [
                'sometimes',
                'required',
                'date',
                $project && $project->status !== 'pending' ? 'after_or_equal:' . $project->start_date : 'after:today'
            ],
            'end_date' => 'sometimes|required|date|after:start_date',
            'member_ids' => 'nullable|array',
            'member_ids.*' => 'exists:researchers,id',
            'status' => [
                'sometimes',
                Rule::in(['pending', 'active', 'completed', 'suspended'])
            ],
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
            'start_date.after_or_equal' => 'لا يمكن تغيير تاريخ البداية للمشاريع النشطة.',
            'end_date.required' => 'تاريخ الانتهاء مطلوب.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخ صالح.',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية.',
            'member_ids.array' => 'أعضاء الفريق يجب أن يكون مصفوفة.',
            'member_ids.*.exists' => 'أحد أعضاء الفريق المحددين غير موجود.',
            'status.in' => 'حالة المشروع المحددة غير صالحة.',
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
            'status' => 'الحالة',
        ];
    }
}