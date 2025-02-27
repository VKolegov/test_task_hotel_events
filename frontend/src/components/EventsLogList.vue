<script setup lang="ts">
import { parseISO } from 'date-fns';
import { QDate, QInput, QSelect, QTable, type QTableProps, useQuasar } from 'quasar';
import { computed, ref, watch } from 'vue';

import { fetchEventsLog } from '@/api/event_logs';
import HttpError from '@/api/http_error';
import { formatDate, formatDateTime } from '@/helpers/date';
import { trimStr } from '@/helpers/string';
import { useMainStore } from '@/stores/main';
import { EventType, EventTypeTitle } from '@/types/enums/EventLogType';
import EventLogEntry, { type EventLogData } from '@/types/EventLogEntry';
import type EventLogsFilter from '@/types/EventLogsFilter';
import type { User } from '@/types/User';

type TableProps = Required<QTableProps>;
type Pagination = Required<TableProps['pagination']>;

const pagination = ref<Pagination>({
  sortBy: 'date',
  descending: true,
  page: 1,
  rowsPerPage: 16,
  rowsNumber: 550,
});

/** filtering **/
interface DateRangeString {
  from: string;
  to: string;
}

interface DateRange {
  from: Date;
  to: Date;
}

const dateRange = ref<DateRangeString | string | null>(null);
const dateRangeMask = 'YYYY-MM-DDTHH:mm:ssZ';
const dateRangeText = computed(() => {
  const date = dateRange.value;
  if (!date) {
    return null;
  }

  if (typeof date === 'string') {
    const d = parseISO(date);
    return formatDate(d);
  }

  if (date.from && date.to) {
    const from = parseISO(date.from);
    const to = parseISO(date.to);

    return formatDate(from) + ' - ' + formatDate(to);
  }

  return null;
});
const dateRangeActual = computed<DateRange | null>(() => {
  const val = dateRange.value;
  if (!val) {
    return null;
  }

  if (typeof val === 'string') {
    const date = parseISO(val);
    return {
      from: date,
      to: date,
    };
  }

  return {
    from: parseISO(val.from),
    to: parseISO(val.to),
  };
});
const selectedTypes = ref<EventType[]>([]);

const availableTypes = Object.values(EventType);
function eventTypeTitle(eventType: EventType): string {
  return EventTypeTitle[eventType] ?? eventType;
}

const store = useMainStore();

const selectedUsers = ref<User[]>([]);
const users = computed(() => store.users);

const tableFilter = computed<EventLogsFilter>(() => {
  const filter: EventLogsFilter = {};

  if (selectedTypes.value.length > 0) {
    filter.type = selectedTypes.value;
  }

  if (selectedUsers.value.length > 0) {
    filter.user_id = selectedUsers.value.map((u) => u.id);
  }

  if (dateRangeActual.value) {
    filter.date_start = dateRangeActual.value.from;
    filter.date_end = dateRangeActual.value.to;
  }

  return filter;
});

watch(tableFilter, () => {
  loadEventLog();
});

const events = ref<EventLogEntry[]>([]);

async function loadEventLog() {
  try {
    const { page, rowsPerPage: pageSize, sortBy, descending } = pagination.value;

    const response = await fetchEventsLog(page, pageSize, tableFilter.value, sortBy, descending);

    const logEntries = response.entities.map((entity) => EventLogEntry.fromResponse(entity));

    events.value.splice(0, events.value.length, ...logEntries);

    pagination.value = {
      ...pagination.value,
      rowsNumber: response.total_count,
    };
  } catch (e) {
    console.error(e);
    if (e instanceof HttpError) {
      alert(`Ошибка при запросе лога событий: ${e.toString()}`);
    }
  }
}

const columns: QTableProps['columns'] = [
  {
    name: 'id',
    label: 'ID',
    field: 'id',
    classes: 'event-list-row__id',
  },
  {
    name: 'date',
    label: 'Дата события',
    field: 'date',
    format: formatDateTime,
    sortable: true,
  },
  {
    name: 'type',
    label: 'Тип события',
    field: 'type',
    format: (val: EventType) => EventTypeTitle[val],
  },
  {
    name: 'info',
    label: 'Информация на момент события',
    field: 'data',
    format: (val: EventLogData) => trimStr(val.toString()),
    classes: 'event-list-row__info',
  },
];

const rowsPerPageOptions = [8, 16, 32, 64];

loadEventLog();

const onRequest: QTableProps['onRequest'] = (r) => {
  pagination.value = {
    ...pagination.value,
    page: r.pagination.page,
    rowsPerPage: r.pagination.rowsPerPage,
    sortBy: r.pagination.sortBy,
    descending: r.pagination.descending,
  };

  loadEventLog();
};

const qDialog = useQuasar();
function onClick(_: Event, e: EventLogEntry) {
  const date = formatDateTime(e.date);
  const type = EventTypeTitle[e.type];
  qDialog.dialog({
    title: `Событие '${type}' от ${date}`,
    message: e.data.toString(),
    class: 'event-info-dialog__content',
  });
}
</script>

<template>
  <div>
    <q-input
      label="Период"
      :model-value="dateRangeText"
      readonly
      filled
    >
      <template #append>
        <q-icon
          name="event"
          class="cursor-pointer"
        >
          <q-popup-proxy
            cover
            transition-show="scale"
            transition-hide="scale"
          >
            <q-date
              v-model="dateRange"
              range
              :mask="dateRangeMask"
            >
              <div class="row items-center justify-end">
                <q-btn
                  v-close-popup
                  label="Close"
                  color="primary"
                  flat
                />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>
    <q-select
      v-model="selectedTypes"
      label="Тип события"
      :options="availableTypes"
      :option-label="eventTypeTitle"
      multiple
    />
    <q-select
      v-model="selectedUsers"
      label="Пользователь системы"
      :options="users"
      option-label="name"
      multiple
    />
    <q-table
      v-model:pagination="pagination"
      :columns="columns"
      :rows="events"
      :rows-per-page-options="rowsPerPageOptions"
      binary-state-sort
      @request="onRequest"
      @row-click="onClick"
    />
  </div>
</template>

<style>
.event-list-row__id {
  width: 30px !important; /* import because of quasar */
}
.event-list-row__info {
  white-space: pre !important; /* import because of quasar */
}
.event-info-dialog__content {
  white-space: pre-line;
}
@media screen and (min-width: 980px) {
  .event-info-dialog__content {
    width: 780px !important; /* import because of quasar */
  }
}
</style>
