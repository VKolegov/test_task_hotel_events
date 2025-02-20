<?php

namespace App\Domain\User\Entities;

use Carbon\Carbon;

class User
{
    public int $id;
    public string $email;
    public ?string $phone;
    public string $userName;
    public string $passwordHash;

    public Carbon $createdAt;
    public Carbon $updatedAt;
    public ?Carbon $deletedAt;

    public ?UserRole $role;

    /**
     * @param int $id
     * @param string $email
     * @param string|null $phone
     * @param string $userName
     * @param string $passwordHash
     * @param Carbon $createdAt
     * @param Carbon $updatedAt
     * @param ?Carbon $deletedAt
     * @param UserRole|null $role
     */
    public function __construct(
        int $id,
        string $email,
        ?string $phone,
        string $userName,
        string $passwordHash,
        Carbon $createdAt,
        Carbon $updatedAt,
        ?Carbon $deletedAt,
        ?UserRole $role
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->phone = $phone;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->role = $role;
    }


}
