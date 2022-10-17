<?php

namespace App\Http\Requests\Api\GameServer;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class CardsSelectionStageRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->readyToFight->status != config('fight.statuses.cards_selected');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
//            'who_id' => ['required', 'numeric', Rule::in([$this->readyToFight->player_one_id, $this->readyToFight->player_two_id])],
        ];
    }
}
