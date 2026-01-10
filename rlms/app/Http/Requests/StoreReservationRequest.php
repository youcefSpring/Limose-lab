<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'purpose' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:500'],
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
            'start_date' => __('start date'),
            'end_date' => __('end date'),
            'quantity' => __('quantity'),
            'purpose' => __('purpose'),
            'notes' => __('notes'),
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
            'start_date.after_or_equal' => __('The start date must be today or in the future'),
            'end_date.after' => __('The end date must be after the start date'),
        ];
    }
}
