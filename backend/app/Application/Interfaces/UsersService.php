<?php

namespace App\Application\Interfaces;

use App\Domain\User\Entities\User;

interface UsersService
{
    public function getById(int $id): ?User;
}
