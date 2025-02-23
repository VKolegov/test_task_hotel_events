<?php

namespace App\Infrastructure\Database\Models;

use App\Infrastructure\Framework\database\factories\HotelGuestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $document_type
 * @property string $document_number
 * @property int|null $user_id
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin \Eloquent
 */
class HotelGuestModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'hotel_guests';

    protected static function newFactory(): HotelGuestFactory
    {
        return HotelGuestFactory::new();
    }
}
