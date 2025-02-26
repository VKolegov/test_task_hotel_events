import type { EventLogEntryResponse } from '@/types/EventLogEntry';
import type PaginatedResponse from '@/types/PaginatedResponse';
import { baseURL, getRequest } from './basic_api';
import type EventLogsFilter from '@/types/EventLogsFilter';

export async function fetchEventsLog(
  page: number,
  pageSize: number,
  filter: EventLogsFilter | null = null,
): Promise<PaginatedResponse<EventLogEntryResponse>> {
  return getRequest(`${baseURL}/events_log`, {
    ...filter,
    page,
    page_size: pageSize,
  });
}
