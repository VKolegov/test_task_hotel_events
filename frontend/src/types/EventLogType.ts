export enum EventType {
  BOOKING = 'booking',
  BOOKING_CANCEL = 'booking_cancel',
  CHECKIN = 'checkin',
  CHECKOUT = 'checkout',
  AUTHENTICATION = 'authentication',
}

export const EventTypeTitle: Record<EventType, string> = {
  [EventType.BOOKING]: 'Бронирование',
  [EventType.BOOKING_CANCEL]: 'Отмена бронирования',
  [EventType.CHECKIN]: 'Заселение',
  [EventType.CHECKOUT]: 'Выселение',
  [EventType.AUTHENTICATION]: 'Аутентификация',
};
