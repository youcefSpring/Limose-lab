<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMaterialRequest extends FormRequest
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
        $materialId = $this->route('material') ? $this->route('material')->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'category_id' => ['required', 'exists:material_categories,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:9999'],
            'status' => ['required', 'in:available,maintenance,retired'],
            'location' => ['required', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:100', Rule::unique('materials', 'serial_number')->ignore($materialId)],
            'purchase_date' => ['nullable', 'date', 'before_or_equal:today'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'maintenance_schedule' => ['nullable', 'in:weekly,monthly,quarterly,yearly'],
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
            'name' => __('material name'),
            'description' => __('description'),
            'category_id' => __('category'),
            'quantity' => __('quantity'),
            'status' => __('status'),
            'location' => __('location'),
            'serial_number' => __('serial number'),
            'purchase_date' => __('purchase date'),
            'image' => __('image'),
            'maintenance_schedule' => __('maintenance schedule'),
        ];
    }
}
