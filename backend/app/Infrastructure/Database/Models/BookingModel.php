<?php

namespace App\Infrastructure\Database\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $hotel_id
 * @property int $room_id
 * @property int|null $user_id
 * @property Carbon $check_in
 * @property Carbon $check_out
 * @property float $price
 * @property string $status
 * @property int|null $updated_by
 * @property HotelRoomModel $room
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin \Eloquent
 */
class BookingModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'bookings';

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(HotelRoomModel::class, 'room_id', 'id');
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(
            HotelGuestModel::class,
            BookingGuestPivot::class,
            'booking_id',
            'guest_id',
        );
    }

    protected static function newFactory(): BookingFactory
    {
        return BookingFactory::new();
    }
}
