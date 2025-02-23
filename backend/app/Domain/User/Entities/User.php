<?php

namespace App\Domain\User\Entities;

use Carbon\Carbon;

readonly final class User
{
    public function __construct(
        public int $id,
        public string $email,
        public ?string $phone,
        public string $userName,
        public string $passwordHash,
        public Carbon $createdAt,
        public Carbon $updatedAt,
        public ?Carbon $deletedAt,
        public ?UserRole $role
    ) {
    }
}
