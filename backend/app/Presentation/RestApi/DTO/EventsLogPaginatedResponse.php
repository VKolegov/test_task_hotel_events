<?php

namespace App\Presentation\RestApi\DTO;

use App\Domain\EventLog\Entities\EventLogEntry;

class EventsLogPaginatedResponse extends AbstractPaginatedResponse
{
    public function serializeEntities(): array
    {
        return $this->entities->map(static function (EventLogEntry $logEntry) {
            return [
                'id' => $logEntry->id,
                'type' => $logEntry->type->value,
                'date' => $logEntry->date->jsonSerialize(),
                'data' => $logEntry->rawData,
                'entity_type' => $logEntry->entityType,
                'entity_id' => $logEntry->entityId,
            ];
        })->toArray();
    }
}
