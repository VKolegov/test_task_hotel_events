<?php

namespace App\Domain\EventLog\Entities;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;

/**
 * @template T of EventLogDataInterface
 */
readonly final class EventLogEntry
{
    public function __construct(
        public int $id,
        public EventLogTypeEnum $type,
        public Carbon $date,
        public ?array $rawData,
        public ?int $hotelId,
        public ?int $userId,
        public ?int $bookingId,
    ) {
    }

    /**
     * @return T
     */
    public function getData(): ?EventLogDataInterface
    {
        return EventLogDataFactory::fromArray(
            $this->type,
            $this->rawData
        );
    }
}
