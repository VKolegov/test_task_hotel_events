<?php

namespace App\Infrastructure\Framework\Providers;

use App\Application\Interfaces\EventLogsServiceInterface;
use App\Application\Services\EventsLogService;
use App\Domain\EventLog\Repositories\EventLogsRepositoryInterface;
use App\Infrastructure\Database\EventsLogRepository;
use Illuminate\Support\ServiceProvider;

class EventsLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EventLogsRepositoryInterface::class, EventsLogRepository::class);
        $this->app->bind(EventLogsServiceInterface::class, EventsLogService::class);
    }
}
