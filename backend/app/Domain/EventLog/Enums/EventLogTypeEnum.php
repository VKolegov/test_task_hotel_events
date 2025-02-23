<?php

namespace App\Domain\EventLog\Enums;

enum EventLogTypeEnum: string
{
    case BOOKING = 'booking';
    case CHECKIN = 'checkin';
    case CHECKOUT = 'checkout';
    case BOOKING_CANCEL = 'booking_cancel';
    case AUTHENTICATION = 'authentication';
}
