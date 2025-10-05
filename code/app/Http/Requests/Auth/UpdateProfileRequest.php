<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $userId = auth()->id();

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)
            ],
            'orcid' => [
                'nullable',
                'regex:/^0000-\d{4}-\d{4}-\d{3}[X\d]$/',
                Rule::unique('users')->ignore($userId)
            ],
            'phone' => [
                'nullable',
                'regex:/^\+[1-9]\d{1,14}$/',
                'max:20'
            ],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'name.max' => 'الاسم لا يجب أن يتجاوز 255 حرف.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالح.',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل.',
            'orcid.regex' => 'تنسيق ORCID غير صالح.',
            'orcid.unique' => 'ORCID مستخدم من قبل.',
            'phone.regex' => 'تنسيق رقم الهاتف غير صالح.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'orcid' => 'ORCID',
            'phone' => 'رقم الهاتف',
        ];
    }
}