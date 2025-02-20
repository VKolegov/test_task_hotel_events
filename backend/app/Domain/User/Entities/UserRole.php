<?php

namespace App\Domain\User\Entities;

use Carbon\Carbon;

class UserRole
{
    public int $id;
    public string $name;
    public string $description;
    public Carbon $createdAt;
    public Carbon $updatedAt;
    public ?Carbon $deletedAt;

    /**
     * @var string[]
     */
    public array $permissions;

    public function __construct(
        int $id,
        string $name,
        string $description,
        Carbon $createdAt,
        Carbon $updatedAt,
        ?Carbon $deletedAt,
        array $permissions
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->permissions = $permissions;
    }


}
