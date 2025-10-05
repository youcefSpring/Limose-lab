<?php

namespace App\Http\Requests\Funding;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFundingSourceRequest extends FormRequest
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
        return [
            'name_ar' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => ['required', Rule::in(['government', 'private', 'international', 'university', 'other'])],
            'contact_info' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:500',
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
            'type.required' => 'نوع مصدر التمويل مطلوب.',
            'type.in' => 'نوع مصدر التمويل المحدد غير صالح.',
            'contact_info.max' => 'معلومات الاتصال لا يجب أن تتجاوز 1000 حرف.',
            'website.url' => 'الموقع الإلكتروني يجب أن يكون رابط صالح.',
            'website.max' => 'الموقع الإلكتروني لا يجب أن يتجاوز 500 حرف.',
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
            'type' => 'النوع',
            'contact_info' => 'معلومات الاتصال',
            'website' => 'الموقع الإلكتروني',
        ];
    }
}