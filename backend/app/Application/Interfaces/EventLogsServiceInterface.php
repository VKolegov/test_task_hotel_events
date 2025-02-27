<?php

namespace App\Application\Interfaces;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Queries\EventsLogQuery;
use App\Domain\Common\DTO\PaginatedEntities;

interface EventLogsServiceInterface
{
    /**
     * @returns PaginatedEntities<EventLogEntry>
     * @throws UnauthorizedException
     */
    public function getPaginatedEventLog(
        EventsLogQuery $q,
    ): PaginatedEntities;
}
