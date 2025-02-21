<?php

namespace Database\Seeders;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use App\Infrastructure\Database\Models\Booking;
use App\Infrastructure\Database\Models\BookingGuest;
use App\Infrastructure\Database\Models\EventLogEntry;
use App\Infrastructure\Database\Models\Hotel;
use App\Infrastructure\Database\Models\HotelGuest;
use App\Infrastructure\Database\Models\HotelRoom;
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


        $users = User::factory(20)->create();

        foreach ($users as $user) {
            EventLogEntry::factory(
                fake()->numberBetween(1, 10)
            )->create([
                'type' => EventLogTypeEnum::AUTHORIZATION,
                'user_id' => $user->id,
                'data' => [
                    'ip' => fake()->ipv4(),
                    'user_agent' => fake()->userAgent(),
                ]
            ]);
        }

        $hotels = Hotel::factory(3)->create();

        foreach ($hotels as $hotel) {
            $guests = HotelGuest::factory(100)->create();

            $rooms = HotelRoom::factory(100)->create([
                'hotel_id' => $hotel->id,
            ]);

            $bookings = Booking::factory(100)->create([
                'hotel_id' => $hotel->id,
                'room_id' => $rooms->random()->id,
                // TODO: user id random
            ]);

            $attributes = [];
            foreach ($bookings as $booking) {

                $guestNumber = fake()->numberBetween(1, 5);
                $randomGuests = $guests->random($guestNumber);

                foreach ($randomGuests as $guest) {
                    $attributes[] = [
                        'booking_id' => $booking->id,
                        'guest_id' => $guest->id,
                    ];
                }
            }
            BookingGuest::insert($attributes);
        }
    }
}
