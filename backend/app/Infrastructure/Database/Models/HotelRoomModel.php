<?php

namespace App\Infrastructure\Database\Models;

use Database\Factories\HotelRoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $name
 * @property string $number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin \Eloquent
 */
class HotelRoomModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hotel_rooms';

    protected static function newFactory(): HotelRoomFactory
    {
        return HotelRoomFactory::new();
    }
}
