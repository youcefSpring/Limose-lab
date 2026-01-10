<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'regex:/^\+213[0-9]{9}$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'research_group' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'locale' => ['nullable', 'in:ar,fr,en'],
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
            'name' => __('name'),
            'email' => __('email address'),
            'password' => __('password'),
            'phone' => __('phone number'),
            'avatar' => __('avatar image'),
            'research_group' => __('research group'),
            'bio' => __('biography'),
            'locale' => __('language'),
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
            'phone.regex' => __('The phone number format must be +213XXXXXXXXX'),
            'avatar.max' => __('The avatar image must not exceed 2MB'),
        ];
    }
}
