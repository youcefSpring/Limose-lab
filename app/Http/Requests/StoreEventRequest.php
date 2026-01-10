<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'event_type' => ['required', 'in:public,restricted'],
            'target_roles' => ['required_if:event_type,restricted', 'array'],
            'target_roles.*' => ['in:admin,researcher,phd_student,partial_researcher,technician,material_manager,guest'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
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
            'title' => __('event title'),
            'description' => __('description'),
            'event_date' => __('event date'),
            'event_time' => __('event time'),
            'location' => __('location'),
            'capacity' => __('capacity'),
            'event_type' => __('event type'),
            'target_roles' => __('target roles'),
            'image' => __('event image'),
        ];
    }
}
