<?php

namespace App\Http\Requests\Api\Balance;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class GetBalanceRequest extends BaseRequest
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
            'code' => ['filled ', Rule::in(config('im_wallet.code_currency'))],
            'balance_type' => ['filled ', Rule::in(config('im_wallet.balance_type'))],
        ];
    }
}
