<?php

namespace App\Infrastructure\Database\Models;

use Database\Factories\HotelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 * @property string $phone
 * @property string $city_name
 * @property string $timezone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin \Eloquent
 */
class HotelModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hotels';

    protected function casts()
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    protected static function newFactory()
    {
        return HotelFactory::new();
    }
}
