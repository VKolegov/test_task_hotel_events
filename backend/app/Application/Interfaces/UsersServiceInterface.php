<?php

namespace App\Application\Interfaces;

use App\Domain\User\Entities\User;

interface UsersServiceInterface
{
    public function getById(int $id): ?User;
}
