<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'equipment_id' => 'required|exists:equipment,id',
            'project_id' => 'nullable|exists:projects,id',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'purpose_ar' => 'nullable|string|max:500',
            'purpose_fr' => 'nullable|string|max:500',
            'purpose_en' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'equipment_id.required' => 'المعدة مطلوبة.',
            'equipment_id.exists' => 'المعدة المحددة غير موجودة.',
            'project_id.exists' => 'المشروع المحدد غير موجود.',
            'start_datetime.required' => 'وقت البداية مطلوب.',
            'start_datetime.date' => 'وقت البداية يجب أن يكون تاريخ ووقت صالح.',
            'start_datetime.after' => 'وقت البداية يجب أن يكون في المستقبل.',
            'end_datetime.required' => 'وقت الانتهاء مطلوب.',
            'end_datetime.date' => 'وقت الانتهاء يجب أن يكون تاريخ ووقت صالح.',
            'end_datetime.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البداية.',
            'purpose_ar.max' => 'الغرض (عربي) لا يجب أن يتجاوز 500 حرف.',
            'purpose_fr.max' => 'الغرض (فرنسي) لا يجب أن يتجاوز 500 حرف.',
            'purpose_en.max' => 'الغرض (إنجليزي) لا يجب أن يتجاوز 500 حرف.',
            'notes.max' => 'الملاحظات لا يجب أن تتجاوز 1000 حرف.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'equipment_id' => 'المعدة',
            'project_id' => 'المشروع',
            'start_datetime' => 'وقت البداية',
            'end_datetime' => 'وقت الانتهاء',
            'purpose_ar' => 'الغرض (عربي)',
            'purpose_fr' => 'الغرض (فرنسي)',
            'purpose_en' => 'الغرض (إنجليزي)',
            'notes' => 'الملاحظات',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Ensure at least one purpose language is provided
            if (empty($this->purpose_ar) && empty($this->purpose_fr) && empty($this->purpose_en)) {
                $validator->errors()->add('purpose_ar', 'يجب توفير الغرض بلغة واحدة على الأقل.');
            }

            // Check if the user has access to the specified project
            if ($this->project_id) {
                $user = auth()->user();
                $project = \App\Models\Project::find($this->project_id);

                if ($project && !$project->members()->where('researcher_id', $user->researcher->id)->exists() &&
                    $project->leader_id !== $user->researcher->id) {
                    $validator->errors()->add('project_id', 'ليس لديك صلاحية لاستخدام هذا المشروع.');
                }
            }
        });
    }
}