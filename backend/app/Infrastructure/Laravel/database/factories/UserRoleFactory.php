<?php

namespace App\Infrastructure\Laravel\database\factories;

use App\Domain\User\Entities\UserRole;
use App\Infrastructure\Database\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserModel>
 */
class UserRoleFactory extends Factory
{
    protected $model = UserRole::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'permissions' => [],
        ];
    }
}
