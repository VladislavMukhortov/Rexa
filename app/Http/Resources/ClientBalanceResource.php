<?php

namespace App\Http\Resources;

class ClientBalanceResource extends BaseResource
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
            'code_currency' =>  $this->code_currency ?? null,
            'balance_type' => $this->balance_type ?? null,
            'amount' => $this->amount ?? null,
            'type' => $this->type ?? null,
            'commission' => $this->commission ?? null,
            'who_type' => $this->who_type ?? null,
            'who_id' => $this->who_id ?? null,
            'owner_id' => $this->owner_id ?? null,
            'owner_type' => $this->owner_type ?? null,
            'updated_at' => $this->updated_at ?? null,
            'created_at' => $this->updated_at ?? null,
        ];
    }
}
