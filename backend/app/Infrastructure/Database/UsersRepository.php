<?php

namespace App\Infrastructure\Database;

use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserRole;
use App\Infrastructure\Database\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersRepository implements \App\Domain\User\Repositories\UsersRepositoryInterface
{

    private string $table = 'users';
    private string $rolesTable = 'user_roles';

    public function getById(int $id): ?User
    {
        $userModel = UserModel::query()
            ->with(['role'])
            ->find($id);

        if (!$userModel) {
            return null;
        }

        $userRole = null;

        if ($userModel->role) {
            $userRole = new UserRole(
                $userModel->role->id,
                $userModel->role->name,
                $userModel->role->description,
                $userModel->role->created_at,
                $userModel->role->updated_at,
                $userModel->role->deleted_at,
                $userModel->role->permissions,
            );
        }

        return new User(
            $userModel->id,
            $userModel->email,
            phone: null,
            userName: $userModel->name,
            passwordHash: $userModel->password,
            createdAt: $userModel->created_at,
            updatedAt: $userModel->updated_at,
            deletedAt: $userModel->deleted_at,
            role: $userRole,
        );

        $row = DB::table($this->table)
            ->select(
                [
                    $this->table . '.*',
                    $this->rolesTable . '.id as role_id',
                    $this->rolesTable . '.name as role_name',
                    $this->rolesTable . '.description as role_description',
                    $this->rolesTable . '.permissions as role_permissions',
                    $this->rolesTable . '.created_at as role_created_at',
                    $this->rolesTable . '.updated_at as role_updated_at',
                    $this->rolesTable . '.deleted_at as role_deleted_at',
                ]
            )
            ->where($this->table . '.id', $id)
            ->leftJoin($this->rolesTable, $this->rolesTable . '.id', '=', $this->table . '.role_id')
            ->first();

        if (!$row) {
            return null;
        }

        $userRole = null;

        if ($row->role_id) {
            $userRole = new UserRole(
                $row->role_id,
                $row->role_name,
                $row->role_description,
                Carbon::parse($row->role_created_at),
                Carbon::parse($row->role_updated_at),
                $row->role_deleted_at ? Carbon::parse($row->role_deleted_at) : null,
                json_decode($row->role_permissions, true),
            );
        }


        return new User(
            id: $row->id,
            email: $row->email,
            phone: null,
            userName: $row->name,
            passwordHash: $row->password,
            createdAt: Carbon::parse($row->created_at),
            updatedAt: Carbon::parse($row->updated_at),
            deletedAt: $row->deleted_at ? Carbon::parse($row->deleted_at) : null,
            role: $userRole,
        );
    }

    public function getByEmail(string $email): User
    {
        // TODO: Implement getByEmail() method.
    }

    public function getByUsername(string $username): User
    {
        // TODO: Implement getByUsername() method.
    }
}
