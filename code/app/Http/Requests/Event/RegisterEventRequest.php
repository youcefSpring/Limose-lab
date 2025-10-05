<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'notes.max' => 'الملاحظات لا يجب أن تتجاوز 1000 حرف.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'notes' => 'الملاحظات',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $event = $this->route('event');
            $user = auth()->user();

            // Check if event registration is open
            if (!$event->isRegistrationOpen()) {
                $validator->errors()->add('event', 'التسجيل غير متاح لهذا الحدث.');
                return;
            }

            // Check if user is already registered
            if ($event->registrations()->where('user_id', $user->id)->exists()) {
                $validator->errors()->add('event', 'أنت مسجل بالفعل في هذا الحدث.');
                return;
            }

            // Check if event is full
            if ($event->isFull()) {
                $validator->errors()->add('event', 'الحدث ممتلئ.');
                return;
            }

            // Check if registration deadline has passed
            if ($event->registration_deadline && now()->gt($event->registration_deadline)) {
                $validator->errors()->add('event', 'انتهى موعد التسجيل لهذا الحدث.');
                return;
            }
        });
    }
}