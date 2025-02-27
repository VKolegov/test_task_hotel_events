import { baseURL, getRequest } from './basic_api';

import type { EventLogEntryResponse } from '@/types/EventLogEntryResponse';
import type EventLogsFilter from '@/types/EventLogsFilter';
import type PaginatedResponse from '@/types/PaginatedResponse';

export async function fetchEventsLog(
  page: number,
  pageSize: number,
  filter: EventLogsFilter | null = null,
  sortBy: string | null = null,
  sortDesc: boolean = false,
): Promise<PaginatedResponse<EventLogEntryResponse>> {
  return getRequest(`${baseURL}/events_log`, {
    ...filter,
    page,
    page_size: pageSize,
    sort_by: sortBy,
    sort_desc: sortDesc ? 1 : 0,
  });
}
