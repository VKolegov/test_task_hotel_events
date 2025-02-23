<?php

namespace App\Presentation\RestApi\Requests;

use App\Domain\EventLog\Enums\EventLogTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetEventLogsRequest extends FormRequest
{
    protected function validationRules(): array
    {
        return [
            ...parent::validationRules(),

            'date_start' => ['date', 'before_or_equal:date_end'],
            'date_end' => ['date', 'after_or_equal:date_start'],

            'type' => ['array',],
            'type.*' => [
                Rule::enum(EventLogTypeEnum::class)
            ],

            'user_id' => ['array',],
            'user_id.*' => [Rule::numeric()->integer()->min(1)]
        ];
    }
}
