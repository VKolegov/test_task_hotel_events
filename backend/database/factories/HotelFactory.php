<?php

namespace Database\Factories;

use App\Infrastructure\Database\Models\HotelModel;
use App\Infrastructure\Database\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
