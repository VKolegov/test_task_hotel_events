<?php

namespace App\Domain\EventLog\Entities;

interface EventLogData
{
    public static function fromArray(array $data): self;
}
