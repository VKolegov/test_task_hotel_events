<?php

namespace App\Infrastructure\Framework\Providers;

use App\Application\Interfaces\UsersServiceInterface;
use App\Application\Services\UsersService;
use App\Domain\User\Repositories\UsersRepositoryInterface;
use App\Infrastructure\Database\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->bind(UsersServiceInterface::class, UsersService::class);
    }
}
