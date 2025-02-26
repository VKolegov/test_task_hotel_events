<?php

namespace App\Application\Services;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Interfaces\EventLogsServiceInterface;
use App\Application\Interfaces\UserPermissionServiceInterface;
use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\EventLogFilter;
use App\Domain\EventLog\Repositories\EventLogsRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserPermission;

class EventsLogService implements EventLogsServiceInterface
{

    public function __construct(
        private readonly EventLogsRepositoryInterface $repo,
        private readonly UserPermissionServiceInterface $permissionService
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
            $this->permissionService->doesNotHavePermission($user, UserPermission::READ_EVENT_LOGS)
        ) {
            throw new UnauthorizedException();
        }

        return $this->repo->getPaginated($pageSize, $page, $filter);
    }
}
