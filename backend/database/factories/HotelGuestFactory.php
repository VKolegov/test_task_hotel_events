<?php

namespace Database\Factories;

use App\Infrastructure\Database\Models\HotelGuestModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelGuestFactory extends Factory
{

    protected $model = HotelGuestModel::class;

    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        return [
            'first_name' => $this->faker->firstName($gender),
            'last_name' => $this->faker->lastName($gender),
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'document_type' => $this->faker->randomElement(['passport', 'drivers_licence']),
            'document_number' => $this->faker->numerify('####-#####-######'),
        ];
    }
}
