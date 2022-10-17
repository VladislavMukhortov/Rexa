<?php

namespace App\Http\Requests\Api\GameServer;

use App\Http\Requests\Api\BaseRequest;
use App\Models\ReadyToFight;

class CancelRegistrationToFightRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ReadyToFight::query()
            ->where('player_one_id', auth()->user()->id)
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
            //
        ];
    }
}
