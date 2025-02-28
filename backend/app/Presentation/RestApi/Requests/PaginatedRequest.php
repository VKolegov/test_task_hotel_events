<?php

namespace App\Presentation\RestApi\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginatedRequest extends FormRequest
{
    protected function validationRules(): array
    {
        return [
            'page' => [Rule::numeric()->integer()->min(1)],
            'page_size' => [Rule::numeric()->integer()->min(10)->max(100)],
        ];
    }
}
