<?php

namespace App\Presentation\RestApi\Requests;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Illuminate\Validation\Rule;

class GetEventLogsRequest extends PaginatedRequest
{
    protected function validationRules(): array
    {
        $dateStartRule = Rule::date();
        if ($this->has('date_end')) {
            $dateStartRule->beforeOrEqual('date_end');
        }

        return [
            ...parent::validationRules(),

            'date_start' => [$dateStartRule],
            'date_end' => [Rule::date()->afterOrEqual('date_start')],

            'type' => [Rule::array()],
            'type.*' => [
                Rule::enum(EventLogTypeEnum::class)
            ],

            'user_id' => [Rule::array()],
            'user_id.*' => [Rule::numeric()->integer()->min(1)],

            'sort_by' => ['string', 'min:1', 'max:16'],
            'sort_desc' => ['boolean'],
        ];
    }
}
