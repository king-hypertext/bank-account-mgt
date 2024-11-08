<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntryRequest extends FormRequest
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
            'account' => 'required|exists:accounts,id',
            'entry_type' => 'required|exists:entry_types,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:100',
            'date' => 'date'
        ];
    }
    public function messages(): array
    {
        return [
            'account.exists' => 'Account does not exist.',
            'entry_type.exists' => 'Entry type does not exist.',
            'amount.min' => 'Amount should be at least 1.',
            'date.date' => 'Date should be a valid date.',
        ];
    }
}
