import { parseISO } from 'date-fns';

import { BookingStatusEnum, BookingStatusTitle } from './enums/BookingStatusEnum';
import type { EventEntityTypeEnum } from './enums/EventEntityTypeEnum';
import { EventType } from './enums/EventLogType';
import type {
  AuthEventLogDataResponse,
  BookingEventLogDataResponse,
  EventLogEntryResponse,
} from './EventLogEntryResponse';

import { formatCurrency } from '@/helpers/currency';
import { formatDate, formatDateTime } from '@/helpers/date';

type EventTypeData = AuthEventLogData | BookingEventLogData;

export interface EventLogData {
  toString(): string;
}

export class AuthEventLogData implements EventLogData {
  ip: string;
  user_agent: string;

  constructor(ip: string, user_agent: string) {
    this.ip = ip;
    this.user_agent = user_agent;
  }

  static fromResponse(response: AuthEventLogDataResponse): AuthEventLogData {
    return new AuthEventLogData(response.ip, response.user_agent);
  }

  toString(): string {
    return `IP: ${this.ip}\nUser Agent: ${this.user_agent}`;
  }
}

export class BookingEventLogData implements EventLogData {
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

  toString() {
    const checkIn = formatDate(this.check_in);
    const checkOut = formatDate(this.check_out);
    const status = BookingStatusTitle[this.status];
    const price = formatCurrency(this.price);

    return `ID комнаты: ${this.room_id}
    Номер комнаты: ${this.room_number}
    Статус: ${status}
    Дата заселения: ${checkIn}
    Дата выселения: ${checkOut}
    Цена: ${price}`;
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
        data = AuthEventLogData.fromResponse(responseData.data);
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
