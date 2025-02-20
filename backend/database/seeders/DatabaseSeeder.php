<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws \JsonException
     */
    public function run(): void
    {

        $now = now();

        $roleId = DB::table('user_roles')->insertGetId([
            'name' => fake()->words(3, asText: true),
            'description' => fake()->text(),
            'permissions' => json_encode([], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => $roleId
        ]);
    }
}
