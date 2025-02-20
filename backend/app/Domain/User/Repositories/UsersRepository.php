<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UsersRepository
{
    public function getById(int $id): ?User;
    public function getByEmail(string $email): User;
    public function getByUsername(string $username): User;
}
