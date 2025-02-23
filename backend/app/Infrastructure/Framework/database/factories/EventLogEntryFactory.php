<?php

namespace App\Infrastructure\Framework\database\factories;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use App\Infrastructure\Database\Models\EventLogEntryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventLogEntryFactory extends Factory
{

    protected $model = EventLogEntryModel::class;

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
