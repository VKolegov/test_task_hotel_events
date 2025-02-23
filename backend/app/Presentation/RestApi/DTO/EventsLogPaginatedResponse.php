<?php

namespace App\Presentation\RestApi\DTO;

use App\Domain\EventLog\Entities\EventLogEntry;

class EventsLogPaginatedResponse extends AbstractPaginatedResponse
{

    public function serializeEntities(): array
    {
        return $this->entities->map(static function (EventLogEntry $entity) {
            return [
                'id' => $entity->id,
                'type' => $entity->type->value,
                'date' => $entity->date->jsonSerialize(),
                'data' => $entity->rawData,
                'hotel_id' => $entity->hotelId,
                'user_id' => $entity->userId,
                'booking_id' => $entity->bookingId,
            ];
        })->toArray();
    }
}
