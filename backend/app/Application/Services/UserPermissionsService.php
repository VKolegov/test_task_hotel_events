<?php

namespace App\Application\Services;

use App\Application\Interfaces\UserPermissionServiceInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserPermission;

class UserPermissionsService implements UserPermissionServiceInterface
{
    public function hasPermission(User $user, UserPermission $permission): bool
    {
        if (!$user->role) {
            return false;
        }

        return in_array($permission, $user->role->permissions, true);
    }

    public function doesNotHavePermission(User $user, UserPermission $permission): bool
    {
        return !$this->hasPermission($user, $permission);
    }
}
