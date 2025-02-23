<?php

namespace App\Infrastructure\Framework\database\factories;

use App\Infrastructure\Database\Models\HotelRoomModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelRoomFactory extends Factory
{
    protected $model = HotelRoomModel::class;

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
