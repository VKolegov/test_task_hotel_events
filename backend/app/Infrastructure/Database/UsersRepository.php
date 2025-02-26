<?php

namespace App\Infrastructure\Database;

use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserRole;
use App\Domain\User\Repositories\UsersRepositoryInterface;
use App\Infrastructure\Database\Models\UserModel;
use Illuminate\Support\Collection;

class UsersRepository implements UsersRepositoryInterface
{

    public function getById(int $id): ?User
    {
        $userModel = UserModel::query()
            ->with(['role'])
            ->find($id);

        if (!$userModel) {
            return null;
        }

        return $this->mapToEntity($userModel);
    }

    public function getAll(): Collection
    {
        $userModels = UserModel::query()
            ->with(['role'])
            ->get();

        return $userModels->map([$this, 'mapToEntity']);
    }

    public function mapToEntity(UserModel $userModel): User
    {
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
    }
}
