<?php

namespace App\Http\Requests\Funding;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectFundingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $projectFunding = $this->route('project_funding');

        return auth()->check() && (
            auth()->user()->isAdmin() ||
            auth()->user()->isLabManager() ||
            (auth()->user()->isResearcher() && auth()->user()->researcher->id === $projectFunding->project->leader_id)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $projectFunding = $this->route('project_funding');

        return [
            'funding_source_id' => [
                'sometimes',
                'required',
                'exists:funding_sources,id',
                Rule::unique('project_funding')->where(function ($query) use ($projectFunding) {
                    return $query->where('project_id', $projectFunding->project_id);
                })->ignore($projectFunding->id ?? null)
            ],
            'amount' => 'sometimes|required|numeric|min:0|max:999999999.99',
            'currency' => ['sometimes', 'required', 'string', 'size:3', Rule::in(['DZD', 'USD', 'EUR', 'GBP'])],
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
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
            'funding_source_id.required' => 'مصدر التمويل مطلوب.',
            'funding_source_id.exists' => 'مصدر التمويل المحدد غير موجود.',
            'funding_source_id.unique' => 'يوجد تمويل مسبق من نفس المصدر لهذا المشروع.',
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
            'funding_source_id' => 'مصدر التمويل',
            'amount' => 'المبلغ',
            'currency' => 'العملة',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ الانتهاء',
            'grant_number' => 'رقم المنحة',
            'notes' => 'الملاحظات',
        ];
    }
}