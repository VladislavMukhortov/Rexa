<?php

namespace App\Http\Requests\Api\GameServer;

use App\Http\Requests\Api\BaseRequest;

class PreparePvpRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'balance_client' => auth()->user()->profile->balance($this->readyToFight->coin, config('im_wallet.balance_type.main')),
            'bet' => $this->readyToFight->bet,
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->readyToFight->player_two_id != auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'balance_client' => ['required', 'numeric', 'min:' . $this->get('bet')],
        ];
    }

    public function messages(): array
    {
        return [
            'balance_client.min' => __('validation.custom.balance_client.min'),
        ];
    }
}
