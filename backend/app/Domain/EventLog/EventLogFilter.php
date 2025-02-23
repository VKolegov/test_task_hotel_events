<?php

namespace App\Domain\EventLog;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;

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


    public static function fromRequest(Request $request): EventLogFilter
    {
        return new self(
            $request->date('date_start'),
            $request->date('date_end'),

            $request->array('types'),

            $request->array('users_id'),
        );
    }
}
