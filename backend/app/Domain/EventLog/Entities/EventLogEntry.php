<?php

namespace App\Domain\EventLog\Entities;

use App\Domain\EventLog\Enums\EventLogEntityType;
use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;

/**
 * @template T of EventLogDataInterface
 */
final readonly class EventLogEntry
{
    public function __construct(
        public int $id,
        public EventLogTypeEnum $type,
        public Carbon $date,
        public ?array $rawData,
        public ?EventLogEntityType $entityType,
        public ?int $entityId,
        public bool $system,
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
