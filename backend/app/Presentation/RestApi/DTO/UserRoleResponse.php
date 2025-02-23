<?php

namespace App\Presentation\RestApi\DTO;

use App\Domain\User\Entities\UserRole;
use JsonSerializable;

class UserRoleResponse implements JsonSerializable
{

    private int $id;
    private string $name;
    private string $description;
    /** @var string[] */
    private array $permissions;

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string[] $permissions
     */
    public function __construct(int $id, string $name, string $description, array $permissions)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->permissions = $permissions;
    }

    public static function fromEntity(UserRole $entity): self
    {
        return new self(
            $entity->id,
            $entity->name,
            $entity->description,
            $entity->permissions
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'permissions' => $this->permissions
        ];
    }
}
