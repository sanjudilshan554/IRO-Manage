<?php

namespace App\Http\Requests\BusinessRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBusinessRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'company_code' => 'required|string|max:50',
            'slbfe_reg_code' => 'nullable|string|max:50',
            'address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'required|string|max:100',
            'status' => 'required',
            'dispatch_countries' => 'nullable|array',
            'dispatch_countries.*' => 'string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'tax_id' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'industry' => 'nullable|string|max:100',
            'business_type' => 'nullable|string|max:100',
            'currency' => 'nullable|string|max:10',
            'bank_account_details' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The business name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'Enter a valid email address.',
            'phone.required' => 'The phone number is required.',
            'logo.image' => 'The logo must be an image file.',
        ];
    }
}
