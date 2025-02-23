<?php

namespace App\Domain\EventLog\Entities;

use App\Domain\EventLog\Enums\EventLogTypeEnum;

class EventLogDataFactory
{
    public static function fromArray(EventLogTypeEnum $type, array $data): ?EventLogDataInterface
    {
        return match ($type) {
            EventLogTypeEnum::AUTHENTICATION => AuthEventLogData::fromArray($data),
            EventLogTypeEnum::BOOKING => BookingEventLogData::fromArray($data),
            default => null,
        };
    }
}
