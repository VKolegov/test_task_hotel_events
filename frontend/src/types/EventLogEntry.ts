import { parseISO } from 'date-fns';
import { EventType } from './EventLogType';
import type { BookingEventLogDataResponse, EventLogEntryResponse } from './EventLogEntryResponse';

type EventTypeData = AuthEventLogData;

export class AuthEventLogData {
  ip: string;
  user_agent: string;

  constructor(ip: string, user_agent: string) {
    this.ip = ip;
    this.user_agent = user_agent;
  }
}

export enum BookingStatusEnum {
  PENDING = 'pending', // Ожидание подтверждения
  CONFIRMED = 'confirmed', // Подтверждено
  CHECKED_IN = 'checked_in', // Гость заселился
  CHECKED_OUT = 'checked_out', // Гость выселился
  CANCELLED = 'cancelled', // Отмена бронирования
  NO_SHOW = 'no_show', // Гость не приехал
  EXPIRED = 'expired', // Истекло (не подтверждено вовремя)
}

export enum EventEntityTypeEnum {
  USER = 'user',
  BOOKING = 'booking',
}

export class BookingEventLogData {
  room_id: number;
  room_number: string;
  status: BookingStatusEnum;
  check_in: Date;
  check_out: Date;
  guests_info: GuestsInfo[];
  price: number;

  constructor(
    roomId: number,
    roomNumber: string,
    status: BookingStatusEnum,
    checkInDate: Date,
    checkOutDate: Date,
    guestsInfo: GuestsInfo[],
    price: number,
  ) {
    this.room_id = roomId;
    this.room_number = roomNumber;
    this.status = status;
    this.check_in = checkInDate;
    this.check_out = checkOutDate;
    this.guests_info = guestsInfo;
    this.price = price;
  }

  static fromResponse(r: BookingEventLogDataResponse): BookingEventLogData {
    return new BookingEventLogData(
      r.room_id,
      r.room_number,
      r.status as BookingStatusEnum,
      parseISO(r.check_in),
      parseISO(r.check_out),
      r.guests_info as GuestsInfo[],
      r.price,
    );
  }
}

export interface GuestsInfo {
  id: number;
  email: string;
  phone: string;
  full_name: string;
  document_info: string;
}

export default class EventLogEntry {
  id: number;
  type: EventType;
  date: Date;
  data: EventTypeData;
  entity_type: EventEntityTypeEnum | null;
  entity_id: number | null;

  constructor(
    id: number,
    type: EventType,
    date: Date,
    data: EventTypeData,
    entity_type: EventEntityTypeEnum | null,
    entity_id: number | null,
  ) {
    this.id = id;
    this.type = type;
    this.date = date;
    this.data = data;
    this.entity_type = entity_type;
    this.entity_id = entity_id;
  }

  static fromResponse(responseData: EventLogEntryResponse) {
    const dataType = responseData.type as EventType;

    let data: EventTypeData;

    switch (dataType) {
      case EventType.AUTHENTICATION:
        data = responseData.data as AuthEventLogData;
        break;
      case EventType.BOOKING:
        data = BookingEventLogData.fromResponse(responseData.data);
        break;
      default:
        data = responseData.data;
        break;
    }

    return new EventLogEntry(
      responseData.id,
      dataType,
      parseISO(responseData.date),
      data,
      responseData.entity_type as EventEntityTypeEnum,
      responseData.entity_id,
    );
  }
}
