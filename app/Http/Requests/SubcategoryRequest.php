<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SubcategoryRequest extends BaseFormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:64',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('subcategories')->ignore($this->id)
            ],
        ];
    }
}
