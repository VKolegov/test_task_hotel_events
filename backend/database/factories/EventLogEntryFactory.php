<?php

namespace Database\Factories;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use App\Infrastructure\Database\Models\EventLogEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventLogEntryFactory extends Factory
{

    protected $model = EventLogEntry::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(
                EventLogTypeEnum::cases(),
            ),
            'date' => $this->faker->dateTimeThisMonth(),
            'data' => []
        ];
    }
}
