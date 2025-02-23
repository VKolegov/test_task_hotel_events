<?php

namespace App\Infrastructure\Framework\database\factories;

use App\Infrastructure\Database\Models\HotelModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = HotelModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, asText: true),
            'slug' => fake()->slug(2),
            'address' => fake()->address,
            'longitude' => fake()->longitude,
            'latitude' => fake()->latitude,
            'phone' => fake()->phoneNumber(),
            'city_name' => fake()->city,
            'timezone' => fake()->timezone,
        ];
    }
}
