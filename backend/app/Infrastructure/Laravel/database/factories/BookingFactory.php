<?php

namespace App\Infrastructure\Laravel\database\factories;

use App\Domain\Hotel\Entities\BookingStatusEnum;
use App\Infrastructure\Database\Models\BookingModel;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = BookingModel::class;

    public function definition()
    {
        $createdAt = CarbonImmutable::parse($this->faker->dateTimeBetween('-3 months', 'now'));

        $days = $this->faker->numberBetween(1, 14);

        $checkIn = $createdAt->addDays(
            $this->faker->numberBetween(3, 100)
        );

        $checkOut = $checkIn->addDays(
            $days
        );

        $price = $this->faker->randomFloat(2000, 50000);


        return [
            'created_at' => $createdAt,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'price' => $price * $days,
            'status' => $this->faker->randomElement(BookingStatusEnum::cases())->value,
        ];
    }
}
