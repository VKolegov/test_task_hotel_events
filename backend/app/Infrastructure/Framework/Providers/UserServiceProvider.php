<?php

namespace App\Infrastructure\Framework\Providers;

use App\Application\Interfaces\UsersServiceInterface;
use App\Application\Services\UsersService;
use App\Infrastructure\Database\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UsersServiceInterface::class,
            static function () {
                $repo = new UsersRepository();

                return new UsersService(
                    $repo
                );
            }
        );
    }
}
