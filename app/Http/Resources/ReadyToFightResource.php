<?php

namespace App\Http\Resources;

class ReadyToFightResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'client_id' => $this->client_id ?? null,
            'bet' => $this->bet ?? null,
            'coin' => $this->coin ?? null,
            'nickname' => $this->profile->nickname ?? null,
            'wins' => $this->wins ?? null,
            'defeats' => $this->defeats ?? null,
            'created_at' => $this->created_at ?? null,
        ];
    }
}
