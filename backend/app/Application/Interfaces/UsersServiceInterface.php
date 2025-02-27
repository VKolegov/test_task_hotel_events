<?php

namespace App\Application\Interfaces;

use App\Application\Exceptions\UnauthorizedException;
use App\Domain\User\Entities\User;
use Illuminate\Support\Collection;

interface UsersServiceInterface
{
    /**
     * @throws UnauthorizedException
     */
    public function getById(User $user, int $id): ?User;

    /**
     * @return Collection<User>
     * @throws UnauthorizedException
     */
    public function getAll(User $user): Collection;
}
