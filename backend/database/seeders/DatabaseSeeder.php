<?php

namespace Database\Seeders;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use App\Domain\Hotel\Entities\BookingStatusEnum;
use App\Domain\User\Entities\UserPermission;
use App\Infrastructure\Database\Models\BookingGuestPivot;
use App\Infrastructure\Database\Models\BookingModel;
use App\Infrastructure\Database\Models\EventLogEntryModel;
use App\Infrastructure\Database\Models\HotelGuestModel;
use App\Infrastructure\Database\Models\HotelModel;
use App\Infrastructure\Database\Models\HotelRoomModel;
use App\Infrastructure\Database\Models\UserModel;
use Illuminate\Database\Eloquent\Collection;
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
            'permissions' => json_encode([
                UserPermission::READ_EVENT_LOGS,
            ], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        UserModel::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => $roleId
        ]);

        $hotels = HotelModel::factory(3)->create();


        $users = UserModel::factory(20)->create();
        $partOfUsers = $users->random(5);


        foreach ($users as $user) {
            EventLogEntryModel::factory(
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

        /** @var Collection<HotelGuestModel> $guests */
        $guests = collect();

        foreach ($partOfUsers as $user) {
            $userGuest = HotelGuestModel::factory()->create([
                'user_id' => $user->id,
            ]);

            $guests->push($userGuest);
        }


        foreach ($hotels as $hotel) {
            /**
             * @var Collection<HotelGuestModel> $guests
             */
            $guests = $guests->merge(
                HotelGuestModel::factory(15)->create()
            );

            $rooms = HotelRoomModel::factory(100)->create([
                'hotel_id' => $hotel->id,
            ]);

            /**
             * @var Collection<BookingModel> $bookings
             */
            $bookings = BookingModel::factory(40)->create([
                'hotel_id' => $hotel->id,
                'room_id' => fn() => $rooms->random()->id,
            ]);

            $userBookings = BookingModel::factory(10)->create([
                'hotel_id' => $hotel->id,
                'room_id' => fn() => $rooms->random()->id,
                'user_id' => fn() => $partOfUsers->random()->id,
            ]);

            $bookings = $bookings->merge($userBookings);


            $attributes = [];
            $eventsData = [];
            foreach ($bookings as $booking) {
                $guestNumber = fake()->numberBetween(1, 3);
                $randomGuests = $guests->random($guestNumber);

                $guestsInfo = [];
                foreach ($randomGuests as $guest) {
                    $attributes[] = [
                        'booking_id' => $booking->id,
                        'guest_id' => $guest->id,
                    ];

                    $guestsInfo[] = [
                        'id' => $guest->id,
                        'email' => $guest->email,
                        'phone' => $guest->phone,
                        'full_name' => $guest->first_name . ' ' . $guest->last_name,
                        'document_info' => $guest->document_type . ' ' . $guest->document_number,
                    ];
                }

                $data = [
                    "room_id" => $booking->room_id,
                    "room_number" => $booking->room->number,
                    "check_in" => $booking->check_in,
                    "check_out" => $booking->check_out,
                    "status" => BookingStatusEnum::CONFIRMED,
                    "price" => $booking->price,
                    "guests_info" => $guestsInfo,
                ];

                $eventsData[] = EventLogEntryModel::factory()->raw([
                    'date' => $booking->created_at,
                    'booking_id' => $booking->id,
                    'hotel_id' => $booking->hotel_id,
                    'type' => EventLogTypeEnum::BOOKING,
                    'user_id' => $booking->user_id,
                    'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
                ]);
            }

            BookingGuestPivot::insert($attributes);
            EventLogEntryModel::insert($eventsData);
        }
    }
}
