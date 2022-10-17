<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    public $logger;
    /**
     * Настроить переданный экземпляр регистратора.
     *
     * @param \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $this->logger = $logger;
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                "[%datetime%] %level_name%: %message%\n%context% %extra%\n",
                'd.m.Y H:i:s', true, true
            ));
        }
    }
}
