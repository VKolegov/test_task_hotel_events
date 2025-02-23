<?php

namespace App\Application\Services;

use App\Application\Interfaces\UsersServiceInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UsersRepositoryInterface;

class UsersService implements UsersServiceInterface
{
    private UsersRepositoryInterface $repo;

    public function __construct(UsersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getById(int $id): ?User
    {
        return $this->repo->getById($id);
    }
}
