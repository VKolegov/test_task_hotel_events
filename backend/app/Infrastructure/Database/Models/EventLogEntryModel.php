<?php

namespace App\Infrastructure\Database\Models;

use Database\Factories\EventLogEntryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $type
 * @property Carbon $date
 * @property int|null $hotel_id
 * @property int|null $booking_id
 * @property int $user_id
 * @property array $data
 * @mixin \Eloquent
 */
class EventLogEntryModel extends Model
{
    use HasFactory;

    protected $table = 'event_logs';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'data' => 'array',
        ];
    }

    protected static function newFactory(): EventLogEntryFactory
    {
        return EventLogEntryFactory::new();
    }
}
