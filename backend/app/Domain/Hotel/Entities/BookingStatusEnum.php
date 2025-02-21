<?php

namespace App\Domain\Hotel\Entities;

enum BookingStatusEnum: string
{
    case PENDING = 'pending';          // Ожидание подтверждения
    case CONFIRMED = 'confirmed';      // Подтверждено
    case CHECKED_IN = 'checked_in';    // Гость заселился
    case CHECKED_OUT = 'checked_out';  // Гость выселился
    case CANCELLED = 'cancelled';      // Отмена бронирования
    case NO_SHOW = 'no_show';          // Гость не приехал
    case EXPIRED = 'expired';          // Истекло (не подтверждено вовремя)
}
