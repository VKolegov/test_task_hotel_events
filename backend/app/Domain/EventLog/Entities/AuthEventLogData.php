<?php

namespace App\Domain\EventLog\Entities;

readonly final class AuthEventLogData implements EventLogData
{
    public function __construct(
        public string $ip,
        public string $userAgent,
    ) {
    }

    public static function fromArray(array $data): EventLogData
    {
        return new self(
            $data['ip'],
            $data['user_agent'],
        );
    }
}
