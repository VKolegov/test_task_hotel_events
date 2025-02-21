<?php

namespace App\Domain\EventLog\Repositories;

use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\Entities\EventLogEntry;
use App\Domain\EventLog\EventLogRepositoryFilter;

interface EventLogEntryRepository
{
    /** @returns PaginatedEntities<EventLogEntry> */
    public function getPaginated(
        int $pageSize,
        int $page = 1,
        ?EventLogRepositoryFilter $filter = null
    ): PaginatedEntities;
}
