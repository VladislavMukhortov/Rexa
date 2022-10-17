<?php

namespace App\Http\Resources;

class ProfileResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'client_id' =>  $this->profile->client_id ?? $this->id ?? null,
            'email' => $this->email ?? null,
            'nickname' => $this->profile->nickname ?? null,
            'first_name' => $this->profile->first_name ?? null,
            'lang' => $this->profile->lang ?? null,
            'main_avatar_id' => $this->profile->main_avatar_id ?? null,
        ];
    }
}
