<?php

namespace App\Application\Services;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Interfaces\EventLogsServiceInterface;
use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\EventLogFilter;
use App\Domain\EventLog\Repositories\EventLogsRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserPermission;

class EventsLogService implements EventLogsServiceInterface
{

    public function __construct(
        private readonly EventLogsRepositoryInterface $repo
    ) {
    }

    /**
     * @param User $user
     * @inheritDoc
     * @throws UnauthorizedException
     */
    public function getPaginatedEventLog(
        User $user,
        int $pageSize,
        int $page = 1,
        ?EventLogFilter $filter = null
    ): PaginatedEntities {
        if (
            !$user->role
            || !in_array(UserPermission::READ_EVENT_LOGS, $user->role->permissions, true)
        ) {
            throw new UnauthorizedException();
        }

        return $this->repo->getPaginated($pageSize, $page, $filter);
    }
}
