<?php

namespace App\Application\Interfaces;

use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserPermission;

interface UserPermissionServiceInterface
{
    public function hasPermission(User $user, UserPermission $permission): bool;

    public function doesNotHavePermission(User $user, UserPermission $permission): bool;
}
