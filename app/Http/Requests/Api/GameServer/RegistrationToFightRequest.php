<?php

namespace App\Http\Requests\Api\GameServer;

use App\Http\Requests\Api\BaseRequest;
use App\Models\ReadyToFight;
use Illuminate\Validation\Rule;

class RegistrationToFightRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'balance_client' => $this->has('coin') ?
                auth()->user()->profile->balance($this->get('coin'), config('im_wallet.balance_type.main')) : 0
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !ReadyToFight::query()
            ->where('player_one_id', auth()->user()->id)
            ->where('status', config('fight.statuses.player_one_ready'))
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bet' => ['required', 'numeric', 'min:10', 'max:10000'],
            'coin' => ['required', Rule::in(config('im_wallet.code_currency'))],
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
