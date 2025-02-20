<?php

namespace App\Presentation\RestApi\DTO;

use App\Domain\User\Entities\User;
use JsonSerializable;

class UserResponse implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $email;
    private ?UserRoleResponse $role;

    public function __construct(int $id, string $name, string $email, ?UserRoleResponse $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public static function fromEntity(User $entity): self
    {
        return new self(
            $entity->id,
            $entity->email,
            $entity->userName,
            $entity->role ? UserRoleResponse::fromEntity($entity->role) : null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role?->jsonSerialize(),
        ];
    }
}
