<?php

namespace App\Domain\EventLog\Entities;

use App\Domain\EventLog\Enums\EventLogTypeEnum;

class EventLogDataFactory
{
    public static function fromArray(EventLogTypeEnum $type, array $data): ?EventLogData
    {
        return match ($type) {
            EventLogTypeEnum::AUTHORIZATION => AuthEventLogData::fromArray($data),
            default => null,
        };
    }
}
