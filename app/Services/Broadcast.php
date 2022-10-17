<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Broadcast
{
    /**
     *
     * Отправляем по сокетам
     */
    public function __construct($classBroadcast, $params)
    {
        try {
            broadcast(new $classBroadcast($params));
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }
}
