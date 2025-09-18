<?php

namespace App\Http\Requests\Funding;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectFundingRequest extends FormRequest
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
            'project_id' => 'required|exists:projects,id',
            'funding_source_id' => 'required|exists:funding_sources,id',
            'amount' => 'required|numeric|min:0|max:999999999.99',
            'currency' => ['required', 'string', 'size:3', Rule::in(['DZD', 'USD', 'EUR', 'GBP'])],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'grant_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'project_id.required' => 'المشروع مطلوب.',
            'project_id.exists' => 'المشروع المحدد غير موجود.',
            'funding_source_id.required' => 'مصدر التمويل مطلوب.',
            'funding_source_id.exists' => 'مصدر التمويل المحدد غير موجود.',
            'amount.required' => 'المبلغ مطلوب.',
            'amount.numeric' => 'المبلغ يجب أن يكون رقم.',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من أو يساوي 0.',
            'amount.max' => 'المبلغ يتجاوز الحد الأقصى المسموح.',
            'currency.required' => 'العملة مطلوبة.',
            'currency.size' => 'العملة يجب أن تكون 3 أحرف.',
            'currency.in' => 'العملة المحددة غير مدعومة.',
            'start_date.required' => 'تاريخ البداية مطلوب.',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخ صالح.',
            'end_date.required' => 'تاريخ الانتهاء مطلوب.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخ صالح.',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية.',
            'grant_number.max' => 'رقم المنحة لا يجب أن يتجاوز 100 حرف.',
            'notes.max' => 'الملاحظات لا يجب أن تتجاوز 1000 حرف.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'project_id' => 'المشروع',
            'funding_source_id' => 'مصدر التمويل',
            'amount' => 'المبلغ',
            'currency' => 'العملة',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ الانتهاء',
            'grant_number' => 'رقم المنحة',
            'notes' => 'الملاحظات',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check if the user has access to the specified project
            if ($this->project_id) {
                $user = auth()->user();
                $project = \App\Models\Project::find($this->project_id);

                if ($project && $user->isResearcher()) {
                    $hasAccess = $project->leader_id === $user->researcher->id ||
                                $project->members()->where('researcher_id', $user->researcher->id)->exists();

                    if (!$hasAccess) {
                        $validator->errors()->add('project_id', 'ليس لديك صلاحية لإضافة تمويل لهذا المشروع.');
                    }
                }
            }

            // Check for duplicate funding for the same project and source
            if ($this->project_id && $this->funding_source_id) {
                $existingFunding = \App\Models\ProjectFunding::where('project_id', $this->project_id)
                    ->where('funding_source_id', $this->funding_source_id)
                    ->exists();

                if ($existingFunding) {
                    $validator->errors()->add('funding_source_id', 'يوجد تمويل مسبق من نفس المصدر لهذا المشروع.');
                }
            }
        });
    }
}