<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'type' => ['required', 'string', 'in:seminar,workshop,conference,meeting,training,other'],
            'agenda' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
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
            'title' => __('messages.Event Title'),
            'description' => __('messages.Description'),
            'event_date' => __('messages.Date'),
            'event_time' => __('messages.Time'),
            'location' => __('messages.Location'),
            'capacity' => __('messages.Maximum Attendees'),
            'type' => __('messages.Event Type'),
            'agenda' => __('messages.Agenda'),
            'image' => __('messages.Event Image'),
        ];
    }
}
