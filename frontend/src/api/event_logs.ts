import { baseURL, getRequest } from './basic_api';

import type { EventLogEntryResponse } from '@/types/EventLogEntry';
import type EventLogsFilter from '@/types/EventLogsFilter';
import type PaginatedResponse from '@/types/PaginatedResponse';

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
