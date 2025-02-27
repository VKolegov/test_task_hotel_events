<?php

namespace App\Domain\EventLog\Repositories;

use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\EventLogFilter;

interface EventLogsRepositoryInterface
{
    /** @returns PaginatedEntities<EventLogEntry> */
    public function getPaginated(
        int $pageSize,
        int $page = 1,
        ?EventLogFilter $filter = null,
        ?string $sortBy = null,
        bool $desc = false
    ): PaginatedEntities;
}
