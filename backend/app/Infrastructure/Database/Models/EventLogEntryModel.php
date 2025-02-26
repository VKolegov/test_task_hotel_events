<?php

namespace App\Infrastructure\Database\Models;

use App\Infrastructure\Laravel\database\factories\EventLogEntryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $type
 * @property Carbon $date
 * @property string|null $entity_type
 * @property int|null $entity_id
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
