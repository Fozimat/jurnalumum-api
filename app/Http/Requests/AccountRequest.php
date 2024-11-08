<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AccountRequest extends BaseFormRequest
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
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('accounts')->ignore($this->id),
            ],
            'initial_balance' => 'required|numeric',
            'initial_balance_date' => 'required|date',
        ];
    }
}
