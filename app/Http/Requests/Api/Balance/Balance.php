<?php

namespace App\Http\Requests\Api\Balance;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class Balance extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'balance_type' => ['required', Rule::in(config('im_wallet.balance_type'))],
            'who_id' => ['filled ', 'numeric', 'exists:profiles,id'],
        ];
    }
}
