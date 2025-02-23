<?php

namespace App\Domain\EventLog\Entities;

use App\Domain\Hotel\Entities\BookingStatusEnum;
use Carbon\Carbon;

readonly final class BookingEventLogData implements EventLogDataInterface
{

    public function __construct(
        public int $roomId,
        public string $roomNumber,
        public Carbon $checkInDate,
        public Carbon $checkOutDate,
        public BookingStatusEnum $status,
        public float $price,
        /** @var BookingEventGuestInfo[] $guests_info */
        public array $guestsInfo,
    ) {
    }

    public static function fromArray(
        array $data
    ): EventLogDataInterface {
        return new self(
            $data['room_id'],
            $data['room_number'],
            Carbon::parse($data['check_in']),
            Carbon::parse($data['check_out']),
            BookingStatusEnum::from($data['status']),
            $data['price'],
            BookingEventGuestInfo::multipleFromArray($data['guests_info']),
        );
    }
}
