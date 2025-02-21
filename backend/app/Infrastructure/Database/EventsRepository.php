<?php

namespace App\Infrastructure\Database;

use App\Domain\Common\DTO\PaginatedEntities;
use App\Domain\EventLog\Entities\EventLogEntry;
use App\Domain\EventLog\Enums\EventLogTypeEnum;
use App\Domain\EventLog\EventLogRepositoryFilter;
use App\Domain\EventLog\Repositories\EventLogEntryRepository;
use App\Infrastructure\Database\Models\EventLogEntryModel;
use Illuminate\Contracts\Database\Query\Builder;

class EventsRepository implements EventLogEntryRepository
{
    public function getPaginated(
        int $pageSize,
        int $page = 1,
        ?EventLogRepositoryFilter $filter = null
    ): PaginatedEntities {
        $query = EventLogEntryModel::query();

        if ($filter) {
            $query = $this->applyFilter($query, $filter);
        }

        $count = $query->count();

        $entities = $query
            ->limit($pageSize)
            ->offset(($page - 1) * $pageSize)
            ->get()
            ->map(function (EventLogEntryModel $model) {
                return new EventLogEntry(
                    $model->id,
                    EventLogTypeEnum::from($model->type),
                    $model->date,
                    $model->data,
                    $model->hotel_id,
                    $model->user_id,
                    $model->booking_id,
                );
            });

        return new PaginatedEntities(
            $page,
            ceil($count / $pageSize),
            $pageSize,
            $count,
            $entities
        );
    }

    private function applyFilter(Builder $query, EventLogRepositoryFilter $filter): Builder
    {
        if ($filter->usersId) {
            $query->whereIn('user_id', $filter->usersId);
        }

        if ($filter->dateStart) {
            $query->whereDate('date', '>=', $filter->dateStart);
        }

        if ($filter->dateEnd) {
            $query->whereDate('date', '<=', $filter->dateEnd);
        }

        if ($filter->types) {
            $query->whereIn('type', $filter->types);
        }

        return $query;
    }
}
