<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UsersRepositoryInterface
{
    public function getById(int $id): ?User;
}
