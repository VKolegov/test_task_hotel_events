<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Interfaces\UserPermissionServiceInterface;
use App\Application\Services\UserPermissionsService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserPermissionServiceInterface::class, UserPermissionsService::class);
    }
}
