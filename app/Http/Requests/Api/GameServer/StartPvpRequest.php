<?php

namespace App\Http\Requests\Api\GameServer;

use App\Http\Requests\Api\BaseRequest;
use App\Models\Client;
use App\Models\ReadyToFight;

/**
 * @property Client $enemy
 * @property ReadyToFight $readyToFight
 */
class StartPvpRequest extends BaseRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'player_one_id' => $this->readyToFight->player_one_id,
            'player_two_id' => auth()->user()->id,
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->readyToFight->client_id != auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

        ];
    }
}
