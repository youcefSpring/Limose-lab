<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isLabManager());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $equipment = $this->route('equipment');

        return [
            'name_ar' => 'sometimes|required|string|max:255',
            'name_fr' => 'sometimes|required|string|max:255',
            'name_en' => 'sometimes|required|string|max:255',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'serial_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('equipment')->ignore($equipment->id ?? null)
            ],
            'category' => 'sometimes|required|string|max:100',
            'location' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date|before_or_equal:today',
            'warranty_expiry' => 'nullable|date|after:purchase_date',
            'maintenance_schedule' => 'nullable|string|max:255',
            'status' => [
                'sometimes',
                Rule::in(['available', 'reserved', 'maintenance', 'out_of_order'])
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'manual_file' => 'nullable|file|mimes:pdf|max:51200',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name_ar.required' => 'الاسم (عربي) مطلوب.',
            'name_ar.max' => 'الاسم (عربي) لا يجب أن يتجاوز 255 حرف.',
            'name_fr.required' => 'الاسم (فرنسي) مطلوب.',
            'name_fr.max' => 'الاسم (فرنسي) لا يجب أن يتجاوز 255 حرف.',
            'name_en.required' => 'الاسم (إنجليزي) مطلوب.',
            'name_en.max' => 'الاسم (إنجليزي) لا يجب أن يتجاوز 255 حرف.',
            'description_ar.max' => 'الوصف (عربي) لا يجب أن يتجاوز 2000 حرف.',
            'description_fr.max' => 'الوصف (فرنسي) لا يجب أن يتجاوز 2000 حرف.',
            'description_en.max' => 'الوصف (إنجليزي) لا يجب أن يتجاوز 2000 حرف.',
            'serial_number.max' => 'الرقم المسلسل لا يجب أن يتجاوز 100 حرف.',
            'serial_number.unique' => 'الرقم المسلسل مستخدم من قبل.',
            'category.required' => 'الفئة مطلوبة.',
            'category.max' => 'الفئة لا يجب أن تتجاوز 100 حرف.',
            'location.max' => 'الموقع لا يجب أن يتجاوز 255 حرف.',
            'purchase_date.date' => 'تاريخ الشراء يجب أن يكون تاريخ صالح.',
            'purchase_date.before_or_equal' => 'تاريخ الشراء لا يمكن أن يكون في المستقبل.',
            'warranty_expiry.date' => 'تاريخ انتهاء الضمان يجب أن يكون تاريخ صالح.',
            'warranty_expiry.after' => 'تاريخ انتهاء الضمان يجب أن يكون بعد تاريخ الشراء.',
            'maintenance_schedule.max' => 'جدولة الصيانة لا يجب أن تتجاوز 255 حرف.',
            'status.in' => 'حالة المعدة المحددة غير صالحة.',
            'photo.image' => 'الصورة يجب أن تكون ملف صورة.',
            'photo.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg.',
            'photo.max' => 'حجم الصورة لا يجب أن يتجاوز 3MB.',
            'manual_file.mimes' => 'ملف الدليل يجب أن يكون PDF.',
            'manual_file.max' => 'حجم ملف الدليل لا يجب أن يتجاوز 50MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name_ar' => 'الاسم (عربي)',
            'name_fr' => 'الاسم (فرنسي)',
            'name_en' => 'الاسم (إنجليزي)',
            'description_ar' => 'الوصف (عربي)',
            'description_fr' => 'الوصف (فرنسي)',
            'description_en' => 'الوصف (إنجليزي)',
            'serial_number' => 'الرقم المسلسل',
            'category' => 'الفئة',
            'location' => 'الموقع',
            'purchase_date' => 'تاريخ الشراء',
            'warranty_expiry' => 'تاريخ انتهاء الضمان',
            'maintenance_schedule' => 'جدولة الصيانة',
            'status' => 'الحالة',
            'photo' => 'الصورة',
            'manual_file' => 'ملف الدليل',
        ];
    }
}