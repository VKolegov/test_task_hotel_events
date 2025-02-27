<?php

namespace App\Domain\User\Entities;

enum UserPermission: string
{
    case READ_EVENT_LOGS = 'read_event_logs';
    case READ_USERS = 'read_users';
}
