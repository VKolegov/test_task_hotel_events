import type {EventLogEntryResponse} from "@/types/EventLogEntry";
import type PaginatedResponse from "@/types/PaginatedResponse";
import {getRequest} from "./basic_api";
import type EventLogsFilter from "@/types/EventLogsFilter";

const baseURL = "http://localhost:8000/api";

export async function fetchEventsLog(page: number, pageSize: number, filter: EventLogsFilter | null = null): Promise<PaginatedResponse<EventLogEntryResponse>> {
  return getRequest(`${baseURL}/events_log`, {
    ...filter,
    page,
    page_size: pageSize,
  });
}
