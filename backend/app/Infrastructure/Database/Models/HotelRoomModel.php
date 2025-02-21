<?php

namespace App\Infrastructure\Database\Models;

use Database\Factories\HotelRoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $name
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @mixin \Eloquent
 */
class HotelRoomModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hotel_rooms';

    protected static function newFactory()
    {
        return HotelRoomFactory::new();
    }
}
