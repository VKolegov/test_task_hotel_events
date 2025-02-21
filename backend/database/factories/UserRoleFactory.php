<?php

namespace Database\Factories;

use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Database\Models\UserModel>
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
