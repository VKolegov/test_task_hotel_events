export enum BookingStatusEnum {
  PENDING = 'pending', // Ожидание подтверждения
  CONFIRMED = 'confirmed', // Подтверждено
  CHECKED_IN = 'checked_in', // Гость заселился
  CHECKED_OUT = 'checked_out', // Гость выселился
  CANCELLED = 'cancelled', // Отмена бронирования
  NO_SHOW = 'no_show', // Гость не приехал
  EXPIRED = 'expired',
}

export const BookingStatusTitle: Record<string, string> = {
  [BookingStatusEnum.PENDING]: 'Ожидание подтверждения',
  [BookingStatusEnum.CONFIRMED]: 'Подтверждено',
  [BookingStatusEnum.CHECKED_IN]: 'Гость заселился',
  [BookingStatusEnum.CHECKED_OUT]: 'Гость выселился',
  [BookingStatusEnum.CANCELLED]: 'Отмена бронирования',
  [BookingStatusEnum.NO_SHOW]: 'Гость не приехал',
  [BookingStatusEnum.EXPIRED]: 'Не успели подтвердить',
};
