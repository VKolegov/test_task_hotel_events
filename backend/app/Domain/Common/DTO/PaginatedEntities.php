<?php

namespace App\Domain\Common\DTO;

use Illuminate\Support\Collection;

/**
 * @template T
 */
readonly class PaginatedEntities
{
    /**
     * @param Collection<T> $entities
     */
    public function __construct(
        public int $currentPage,
        public int $totalPages,
        public int $pageSize,
        public int $totalCount,
        public Collection $entities
    ) {
    }
}
