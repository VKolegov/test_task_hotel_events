<?php

namespace App\Presentation\RestApi\Mappers;

use App\Domain\EventLog\EventLogFilter;
use App\Presentation\RestApi\Requests\GetEventLogsRequest;

class EventLogFilterMapper
{
    public static function filterFromRequest(GetEventLogsRequest $request): EventLogFilter
    {
        return (new EventLogFilter())
            ->setDateStart(
                $request->date('date_start')
            )
            ->setDateEnd(
                $request->date('date_end')
            )
            ->setTypes(
                $request->array('types'),
            )
            ->setUsersId(
                $request->array('user_id')
            );
    }
}
