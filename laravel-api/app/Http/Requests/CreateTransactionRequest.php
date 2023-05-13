<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_number' => ['required', 'numeric', 'exists:accounts,id'],
            'amount' => ['required', 'numeric'],
            'source_account_number' => ['required', 'numeric', 'exists:accounts,id']
        ];
    }

    public function messages()
    {
        return [
            'account_number.required' => 'The account number field is required',
            'amount.required' => 'The amount field is required',
            'source_account_number.required' => 'The source account number field is required',
        ];
    }
}
