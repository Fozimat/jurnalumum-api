<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Models\Journal;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;


class JournalRequest extends BaseFormRequest
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
            'transaction_code' => ['required', 'string', Rule::unique(Journal::class, 'transaction_code')],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'detail' => ['required', 'array'],
            'detail.*.account_id' => ['required', Rule::exists(Account::class, 'id')],
            'detail.*.debit' => ['required', 'numeric'],
            'detail.*.credit' => ['required', 'numeric'],
        ];
    }
}
