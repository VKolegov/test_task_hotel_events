<?php

namespace App\Presentation\RestApi\DTO;

use App\Domain\Common\DTO\PaginatedEntities;
use Illuminate\Support\Collection;
use JsonSerializable;

abstract class AbstractPaginatedResponse implements JsonSerializable
{
    public function __construct(
        public int $currentPage,
        public int $totalPages,
        public int $pageSize,
        public int $totalCount,
        public Collection $entities
    ) {
    }

    public static function fromDTO(PaginatedEntities $paginatedEntities): static
    {
        return new static(
            $paginatedEntities->currentPage,
            $paginatedEntities->totalPages,
            $paginatedEntities->pageSize,
            $paginatedEntities->totalCount,
            $paginatedEntities->entities
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
            'page_size' => $this->pageSize,
            'total_count' => $this->totalCount,
            'entities' => $this->serializeEntities(),
        ];
    }

    abstract public function serializeEntities(): array;
}
