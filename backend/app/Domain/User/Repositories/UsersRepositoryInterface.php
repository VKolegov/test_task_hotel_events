<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;
use Illuminate\Support\Collection;

interface UsersRepositoryInterface
{
    public function getById(int $id): ?User;
    /** @returns Collection<User> */
    public function getAll(): Collection;
}
