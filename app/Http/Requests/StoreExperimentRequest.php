<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperimentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'experiment_type' => ['required', 'in:report,data,publication,other'],
            'experiment_date' => ['required', 'date', 'before_or_equal:today'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,csv,zip', 'max:10240'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'project_id' => __('project'),
            'title' => __('experiment title'),
            'description' => __('description'),
            'experiment_type' => __('experiment type'),
            'experiment_date' => __('experiment date'),
            'files' => __('files'),
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
            'files.max' => __('Maximum 5 files allowed per experiment'),
            'files.*.max' => __('Each file must not exceed 10MB'),
        ];
    }
}
