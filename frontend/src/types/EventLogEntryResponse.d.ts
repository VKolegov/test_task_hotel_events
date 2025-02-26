export interface EventLogEntryResponse {
  id: number;
  type: string;
  date: string;
  data: AuthEventLogDataResponse | BookingEventLogDataResponse;
  entity_type: string | null;
  entity_id: number | null;
}

export interface AuthEventLogDataResponse {
  ip: string;
  user_agent: string;
}

export interface BookingEventLogDataResponse {
  price: number;
  status: string;
  room_id: number;
  check_in: string;
  check_out: string;
  guests_info: BookingEventLogDataResponseGuestsInfo[];
  room_number: string;
}

export interface BookingEventLogDataResponseGuestsInfo {
  id: number;
  email: string;
  phone: string;
  full_name: string;
  document_info: string;
}
