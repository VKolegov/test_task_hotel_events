<?php

namespace Database\Seeders;

use App\Domain\EventLog\Entities\AuthEventLogData;
use App\Domain\EventLog\Entities\BookingEventGuestInfo;
use App\Domain\EventLog\Entities\BookingEventLogData;
use App\Domain\EventLog\Enums\EventLogEntityType;
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
use JsonException;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws JsonException
     */
    public function run(): void
    {
        $now = now();

        $roleId = DB::table('user_roles')->insertGetId([
            'name' => fake()->words(3, asText: true),
            'description' => fake()->text(),
            'permissions' => json_encode([
                UserPermission::READ_EVENT_LOGS,
                UserPermission::READ_USERS,
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
                'type' => EventLogTypeEnum::AUTHENTICATION,
                'entity_type' => EventLogEntityType::USER,
                'entity_id' => $user->id,
                'data' => static fn() => (new AuthEventLogData(
                    fake()->ipv4(),
                    fake()->userAgent(),
                ))->toArray()
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

                    $guestsInfo[] = new BookingEventGuestInfo(
                        $guest->id,
                        $guest->first_name . ' ' . $guest->last_name,
                        $guest->phone,
                        $guest->email,
                        $guest->document_type . ' ' . $guest->document_number,
                    );
                }

                $logData = new BookingEventLogData(
                    $booking->room_id,
                    $booking->room->number,
                    $booking->check_in,
                    $booking->check_out,
                    BookingStatusEnum::CONFIRMED,
                    $booking->price,
                    $guestsInfo,
                );

                $eventsData[] = EventLogEntryModel::factory()->raw([
                    'date' => $booking->created_at,
                    'type' => EventLogTypeEnum::BOOKING,
                    'entity_type' => EventLogEntityType::BOOKING,
                    'entity_id' => $booking->id,
                    'data' => json_encode($logData->toArray(), JSON_UNESCAPED_UNICODE),
                ]);
            }

            BookingGuestPivot::insert($attributes);
            EventLogEntryModel::insert($eventsData);
        }
    }
}
