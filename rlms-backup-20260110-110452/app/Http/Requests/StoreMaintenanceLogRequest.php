<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceLogRequest extends FormRequest
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
            'material_id' => ['required', 'exists:materials,id'],
            'maintenance_type' => ['required', 'in:preventive,corrective,inspection'],
            'description' => ['required', 'string', 'max:2000'],
            'scheduled_date' => ['required', 'date'],
            'completed_date' => ['nullable', 'date', 'after_or_equal:scheduled_date'],
            'technician_id' => ['required', 'exists:users,id'],
            'cost' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'notes' => ['nullable', 'string', 'max:1000'],
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
            'material_id' => __('material'),
            'maintenance_type' => __('maintenance type'),
            'description' => __('description'),
            'scheduled_date' => __('scheduled date'),
            'completed_date' => __('completed date'),
            'technician_id' => __('technician'),
            'cost' => __('cost'),
            'notes' => __('notes'),
        ];
    }
}
