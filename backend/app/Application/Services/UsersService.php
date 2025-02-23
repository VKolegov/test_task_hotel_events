<?php

namespace App\Application\Services;

use App\Application\Interfaces\UsersServiceInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UsersRepository;

class UsersService implements UsersServiceInterface
{
    private UsersRepository $repo;

    public function __construct(UsersRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getById(int $id): ?User
    {
        return $this->repo->getById($id);
    }
}
