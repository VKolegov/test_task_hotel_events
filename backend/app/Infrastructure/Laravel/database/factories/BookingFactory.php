<?php

namespace App\Infrastructure\Laravel\database\factories;

use App\Domain\Hotel\Entities\BookingStatusEnum;
use App\Infrastructure\Database\Models\BookingModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = BookingModel::class;

    public function definition()
    {
        $createdAt = \Carbon\CarbonImmutable::parse($this->faker->dateTimeBetween('-3 months', '-2 months'));

        $checkOut = \Carbon\CarbonImmutable::parse($this->faker->dateTimeBetween('-10 days', '+14 days'));
        $checkIn = $checkOut->subDays(
            $this->faker->numberBetween(1, 14)
        );

        return [
            'created_at' => $createdAt,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'price' => $this->faker->randomFloat(2, 10000, 3000000),
            'status' => $this->faker->randomElement(BookingStatusEnum::cases())->value,
        ];
    }
}
