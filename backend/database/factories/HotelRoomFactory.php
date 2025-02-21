<?php

namespace Database\Factories;

use App\Infrastructure\Database\Models\Hotel;
use App\Infrastructure\Database\Models\HotelRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelRoomFactory extends Factory
{
    protected $model = HotelRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(asText: true),
            'number' => fake()->unique()->numberBetween(1, 5000),
        ];
    }
}
