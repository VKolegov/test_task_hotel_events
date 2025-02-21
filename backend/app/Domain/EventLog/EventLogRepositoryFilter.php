<?php

namespace App\Domain\EventLog;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;

class EventLogRepositoryFilter
{
    public ?Carbon $dateStart = null;
    public ?Carbon $dateEnd = null;

    /** @var EventLogTypeEnum[]|null */
    public ?array $types = null;

    /** @var int[] */
    public ?array $usersId = null;



}
