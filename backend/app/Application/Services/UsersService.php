<?php

namespace App\Application\Services;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Interfaces\UserPermissionServiceInterface;
use App\Application\Interfaces\UsersServiceInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserPermission;
use App\Domain\User\Repositories\UsersRepositoryInterface;
use Illuminate\Support\Collection;

class UsersService implements UsersServiceInterface
{
    public function __construct(
        private readonly UsersRepositoryInterface $repo,
        private readonly UserPermissionServiceInterface $permissionService,
    ) {
    }

    public function getById(User $user, int $id): ?User
    {
        if (
            $user->id !== $id
            || $this->permissionService->doesNotHavePermission($user, UserPermission::READ_USERS)
        ) {
            throw new UnauthorizedException();
        }

        return $this->repo->getById($id);
    }

    public function getAll(User $user): Collection
    {
        if (
            $this->permissionService->doesNotHavePermission($user, UserPermission::READ_USERS)
        ) {
            throw new UnauthorizedException();
        }

        return $this->repo->getAll();
    }
}
