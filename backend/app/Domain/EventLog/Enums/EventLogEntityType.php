<?php

namespace App\Domain\EventLog\Enums;

enum EventLogEntityType: string {
  case USER = 'user';
  case BOOKING = 'booking';
}
