<?php

namespace App\Domain\EventLog;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;

class EventLogFilter
{
    public ?Carbon $dateStart = null;
    public ?Carbon $dateEnd = null;

    /** @var EventLogTypeEnum[]|null */
    public ?array $types = null;

    /** @var int[] */
    public ?array $usersId = null;


    public function setDateStart(?Carbon $dateStart): EventLogFilter
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function setDateEnd(?Carbon $dateEnd): EventLogFilter
    {
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
     * @param int[]|null $usersId
     */
    public function setUsersId(?array $usersId): EventLogFilter
    {
        $this->usersId = $usersId;
        return $this;
    }

}
