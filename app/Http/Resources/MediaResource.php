<?php

namespace App\Http\Resources;

class MediaResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'client_id' =>  $this->client_id,
            'path' => $this->path,
            'type' => $this->type,
        ];
    }
}
