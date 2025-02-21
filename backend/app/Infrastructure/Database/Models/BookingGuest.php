<?php

namespace App\Infrastructure\Database\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property int $booking_id
 * @property int $guest_id
 * @mixin \Eloquent
 */
class BookingGuest extends Pivot
{
    protected $table = 'bookings_hotel_guests';
}
