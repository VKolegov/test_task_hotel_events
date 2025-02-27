<?php

namespace App\Application\Queries;

use App\Domain\EventLog\EventLogFilter;
use App\Domain\User\Entities\User;


class EventsLogQuery
{
    public string $sortBy = 'date';
    public bool $desc = true;

    public function __construct(
        public User $user,
        public int $pageSize = 20,
        public int $page = 1,
        public ?EventLogFilter $filter = null,
    ) {
    }

    public function setOrdering(string $sortBy, bool $desc = true): void
    {
        $this->sortBy = $sortBy;
        $this->desc = $desc;
    }
}
