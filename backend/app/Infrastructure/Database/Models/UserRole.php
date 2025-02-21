<?php

namespace App\Infrastructure\Database\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string[] $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 */
class UserRole extends Model
{
    protected $table = 'user_roles';

    protected function casts(): array
    {
        return [
            'permissions' => 'array'
        ];
    }
}
