<?php

namespace App\Presentation\RestApi\Mappers;

use App\Domain\EventLog\Enums\EventLogEntityType;
use App\Domain\EventLog\EventLogFilter;
use App\Presentation\RestApi\Requests\GetEventLogsRequest;

class EventLogFilterMapper
{
    public static function filterFromRequest(GetEventLogsRequest $request): EventLogFilter
    {
        $filter = (new EventLogFilter())
            ->setDateStart(
                $request->date('date_start')
            )
            ->setDateEnd(
                $request->date('date_end')
            )
            ->setTypes(
                $request->array('type'),
            );

        if ($request->has('user_id')) {
          $filter->addFilterByEntity(EventLogEntityType::USER, $request->array('user_id'));
        }

        return $filter;
    }
}
