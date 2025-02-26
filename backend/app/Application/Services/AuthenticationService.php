<?php

namespace App\Application\Services;

use App\Domain\User\Entities\User;
use App\Infrastructure\Database\UsersRepository;

class AuthenticationService
{
    /**
     * DEBUG PURPOSES ONLY
     */
    public function getAdmin(): ?User
    {
        return (new UsersRepository())->getById(1);
    }
}
