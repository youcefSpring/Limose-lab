<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'researcher', 'visitor', 'lab_manager'])],
            'orcid' => [
                'nullable',
                'regex:/^0000-\d{4}-\d{4}-\d{3}[X\d]$/',
                'unique:users,orcid'
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
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'role.required' => 'الدور مطلوب.',
            'role.in' => 'الدور المحدد غير صالح.',
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
            'password' => 'كلمة المرور',
            'role' => 'الدور',
            'orcid' => 'ORCID',
            'phone' => 'رقم الهاتف',
        ];
    }
}