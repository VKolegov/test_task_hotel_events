export enum EventEntityTypeEnum {
  USER = 'user',
  BOOKING = 'booking',
}

export const EventEntityTypeTitle: Record<string, string> = {
  [EventEntityTypeEnum.USER]: 'Пользователь',
  [EventEntityTypeEnum.BOOKING]: 'Бронирование',
};
