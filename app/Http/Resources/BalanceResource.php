<?php

namespace App\Http\Resources;

/**
 * @property mixed $commission
 * @property mixed $amount
 * @property mixed $code_currency
 * @property mixed $named_type
 * @property mixed $type
 * @property mixed $created_at
 */
class BalanceResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'type_info' =>  [
                'key' => $this->type,
                'title' => $this->named_type,
            ],
            'currency_info' => [
                'code' => $this->code_currency,
                'title' => config("im_wallet.code_currency_name.{$this->code_currency}") ?? $this->code_currency
            ],
            'amount' => $this->amount,
            'commission' => $this->commission,
            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at?->format('d.m.Y H:i'),
        ];
    }
}
