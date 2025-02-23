<?php

namespace App\Domain\EventLog;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;

readonly class EventLogFilter
{
    public function __construct(
        public ?Carbon $dateStart = null,
        public ?Carbon $dateEnd = null,

        /** @var EventLogTypeEnum[]|null */
        public ?array $types = null,

        /** @var int[] */
        public ?array $usersId = null,
    ) {
    }
}
