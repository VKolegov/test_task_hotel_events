<?php

namespace App\Domain\EventLog\Entities;

interface EventLogDataInterface
{
    public static function fromArray(array $data): self;
}
