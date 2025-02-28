<?php

namespace App\Infrastructure\Laravel;

class Application extends \Illuminate\Foundation\Application
{
    public function booting($callback): void
    {
        parent::booting($callback);
        $this->loadEnvironmentFrom($this->environmentFile);
    }

    public function loadEnvironmentFrom($file): Application
    {
        return parent::loadEnvironmentFrom('/../../../.env');
    }
}
