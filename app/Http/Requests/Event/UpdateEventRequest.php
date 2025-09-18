<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $event = $this->route('event');

        return auth()->check() && (
            auth()->user()->isAdmin() ||
            auth()->user()->isLabManager() ||
            (auth()->user()->id === $event->organizer_id)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $event = $this->route('event');

        return [
            'title_ar' => 'sometimes|required|string|max:255',
            'title_fr' => 'sometimes|required|string|max:255',
            'title_en' => 'sometimes|required|string|max:255',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'type' => ['sometimes', 'required', Rule::in(['seminar', 'workshop', 'conference', 'summer_school', 'meeting', 'other'])],
            'start_date' => [
                'sometimes',
                'required',
                'date',
                $event && $event->status !== 'draft' ? 'after_or_equal:' . $event->start_date : 'after:today'
            ],
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location_ar' => 'nullable|string|max:255',
            'location_fr' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1|max:10000',
            'registration_deadline' => 'sometimes|required|date|before:start_date',
            'status' => [
                'sometimes',
                Rule::in(['draft', 'published', 'ongoing', 'completed', 'cancelled'])
            ],
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:15360',
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
            'type.required' => 'نوع الحدث مطلوب.',
            'type.in' => 'نوع الحدث المحدد غير صالح.',
            'start_date.required' => 'تاريخ البداية مطلوب.',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخ صالح.',
            'start_date.after' => 'تاريخ البداية يجب أن يكون في المستقبل.',
            'start_date.after_or_equal' => 'لا يمكن تغيير تاريخ البداية للأحداث المنشورة.',
            'end_date.required' => 'تاريخ الانتهاء مطلوب.',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخ صالح.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون مساوي أو بعد تاريخ البداية.',
            'start_time.date_format' => 'تنسيق وقت البداية غير صالح (HH:MM).',
            'end_time.date_format' => 'تنسيق وقت الانتهاء غير صالح (HH:MM).',
            'end_time.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البداية.',
            'location_ar.max' => 'الموقع (عربي) لا يجب أن يتجاوز 255 حرف.',
            'location_fr.max' => 'الموقع (فرنسي) لا يجب أن يتجاوز 255 حرف.',
            'location_en.max' => 'الموقع (إنجليزي) لا يجب أن يتجاوز 255 حرف.',
            'max_participants.integer' => 'الحد الأقصى للمشاركين يجب أن يكون رقم صحيح.',
            'max_participants.min' => 'الحد الأقصى للمشاركين يجب أن يكون 1 أو أكثر.',
            'max_participants.max' => 'الحد الأقصى للمشاركين لا يمكن أن يتجاوز 10000.',
            'registration_deadline.required' => 'موعد انتهاء التسجيل مطلوب.',
            'registration_deadline.date' => 'موعد انتهاء التسجيل يجب أن يكون تاريخ صالح.',
            'registration_deadline.before' => 'موعد انتهاء التسجيل يجب أن يكون قبل بداية الحدث.',
            'status.in' => 'حالة الحدث المحددة غير صالحة.',
            'attachment.mimes' => 'المرفق يجب أن يكون من الأنواع المسموحة.',
            'attachment.max' => 'حجم المرفق لا يجب أن يتجاوز 15MB.',
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
            'type' => 'النوع',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ الانتهاء',
            'start_time' => 'وقت البداية',
            'end_time' => 'وقت الانتهاء',
            'location_ar' => 'الموقع (عربي)',
            'location_fr' => 'الموقع (فرنسي)',
            'location_en' => 'الموقع (إنجليزي)',
            'max_participants' => 'الحد الأقصى للمشاركين',
            'registration_deadline' => 'موعد انتهاء التسجيل',
            'status' => 'الحالة',
            'attachment' => 'المرفق',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $event = $this->route('event');

            // Check if reducing max_participants below current registrations
            if ($this->has('max_participants') && $this->max_participants) {
                $currentRegistrations = $event->registrations()->count();
                if ($this->max_participants < $currentRegistrations) {
                    $validator->errors()->add('max_participants',
                        "لا يمكن تقليل الحد الأقصى للمشاركين إلى أقل من التسجيلات الحالية ({$currentRegistrations}).");
                }
            }

            // Validate time logic when both start_time and end_time are provided
            if ($this->start_time && $this->end_time) {
                $startTime = \Carbon\Carbon::createFromFormat('H:i', $this->start_time);
                $endTime = \Carbon\Carbon::createFromFormat('H:i', $this->end_time);

                if ($endTime->lte($startTime)) {
                    $validator->errors()->add('end_time', 'وقت الانتهاء يجب أن يكون بعد وقت البداية.');
                }
            }
        });
    }
}