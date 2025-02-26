<?php

namespace App\Domain\EventLog;

use App\Domain\EventLog\Enums\EventLogEntityType;
use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;

class EventLogFilter
{
    public ?Carbon $dateStart = null;
    public ?Carbon $dateEnd = null;

    /** @var EventLogTypeEnum[]|null */
    public ?array $types = null;

    /** @var array<EventLogEntityType, int[]> */
    public array $entities = [];

    public function setDateStart(?Carbon $dateStart): EventLogFilter
    {
        if ($dateStart) {
            $dateStart->startOfDay()->setTimezone('UTC');
        }
        $this->dateStart = $dateStart;
        return $this;
    }

    public function setDateEnd(?Carbon $dateEnd): EventLogFilter
    {
        if ($dateEnd) {
            $dateEnd->endOfDay()->setTimezone('UTC');
        }
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @param EventLogTypeEnum[]|null $types
     */
    public function setTypes(?array $types): EventLogFilter
    {
        $this->types = $types;
        return $this;
    }

    /**
     * @param int[] $ids
     */
    public function addFilterByEntity(EventLogEntityType $type, array $ids): self
    {
        $this->entities[$type->value] = $ids;
        return $this;
    }

}
