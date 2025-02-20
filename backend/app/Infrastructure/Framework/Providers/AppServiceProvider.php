<?php

namespace App\Infrastructure\Framework\Providers;

use App\Application\Interfaces\UsersService;
use App\Infrastructure\Database\UsersRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(UsersService::class, static function () {
            $repo = new UsersRepository();

            return new \App\Application\Services\UsersService(
                $repo
            );
        });
    }
}
