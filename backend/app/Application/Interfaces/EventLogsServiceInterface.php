<?php

namespace App\Application\Interfaces;

use App\Application\Exceptions\UnauthorizedException;
use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\Entities\EventLogEntry;
use App\Domain\EventLog\EventLogFilter;
use App\Domain\User\Entities\User;

interface EventLogsServiceInterface
{
    /**
     * @returns PaginatedEntities<EventLogEntry>
     * @throws UnauthorizedException
     */
    public function getPaginatedEventLog(
        User $user,
        int $pageSize,
        int $page = 1,
        ?EventLogFilter $filter = null
    ): PaginatedEntities;
}
