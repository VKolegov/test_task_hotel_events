<?php

namespace App\Infrastructure\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string[] $permissions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @mixin \Eloquent
 */
class UserRoleModel extends Model
{
    protected $table = 'user_roles';

    protected function casts(): array
    {
        return [
            'permissions' => 'array'
        ];
    }
}
