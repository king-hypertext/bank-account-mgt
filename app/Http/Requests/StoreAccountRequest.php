<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            'account_number' => 'required|numeric|unique:accounts,account_number',
            'name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|exists:account_types,id',
            'account_status' => 'required|exists:account_statuses,id',
            'account_description' => 'nullable|string|max:255',
            'account_address' => 'required|string|max:255',
            'initial_amount' => 'required|numeric',
            'created_at' => 'date'
        ];
    }
    public function messages(): array
    {
        return [
            'bank_name.required' => 'Bank name is required.',
            'name.required' => 'Account name is required.',
            'account_description.max' => 'Account description cannot be more than 255 characters.',
            'created_at.date' => 'account creation date should be a valid date.',
        ];
    }
}
