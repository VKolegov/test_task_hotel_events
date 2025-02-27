<?php

namespace App\Application\Services;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Interfaces\EventLogsServiceInterface;
use App\Application\Interfaces\UserPermissionServiceInterface;
use App\Application\Queries\EventsLogQuery;
use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\Repositories\EventLogsRepositoryInterface;
use App\Domain\User\Entities\UserPermission;

class EventsLogService implements EventLogsServiceInterface
{

    public function __construct(
        private readonly EventLogsRepositoryInterface $repo,
        private readonly UserPermissionServiceInterface $permissionService
    ) {
    }

    /**
     * @inheritDoc
     * @throws UnauthorizedException
     */
    public function getPaginatedEventLog(
        EventsLogQuery $q,
    ): PaginatedEntities {
        if (
            $this->permissionService->doesNotHavePermission($q->user, UserPermission::READ_EVENT_LOGS)
        ) {
            throw new UnauthorizedException();
        }

        return $this->repo->getPaginated(
            $q->pageSize,
            $q->page,
            $q->filter,
            $q->sortBy,
            $q->desc,
        );
    }
}
