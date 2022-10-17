<?php

namespace App\Http\Requests\Api\Balance;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class CreditBalanceRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'balance_client' => $this->has('coin_code') && $this->has('balance_type') ?
                auth()->user()->profile->balance($this->get('coin_code'), $this->get('balance_type')) : 0
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1', 'max:10000'],
            'coin_code' => ['required', Rule::in(config('im_wallet.code_currency'))],
            'balance_type' => ['required', Rule::in(config('im_wallet.balance_type'))],
            'balance_client' => ['required', 'numeric', 'min:' . $this->get('amount')],
        ];
    }


    public function messages(): array
    {
        return [
            'balance_client.min' => __('validation.custom.balance_client.min'),
        ];
    }
}
