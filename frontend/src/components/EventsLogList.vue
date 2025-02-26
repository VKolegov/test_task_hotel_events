<script setup lang="ts">
import { computed, type ComputedRef, ref, type Ref, watch } from 'vue';
import { QTable, QSelect, type QTableProps, QInput, QDate } from 'quasar';
import { parseISO } from 'date-fns';

import EventLogEntry from '@/types/EventLogEntry';
import { EventTypeTitle, EventType } from '@/types/EventLogType';
import type { User } from '@/types/User';
import type EventLogsFilter from '@/types/EventLogsFilter';

import HttpError from '@/api/http_error';
import { fetchEventsLog } from '@/api/event_logs';
import { formatDate, formatDateTime } from '@/helpers/date';
import { useMainStore } from '@/stores/main';

type Pagination = Required<QTableProps['pagination']>;

const pagination: Ref<Pagination> = ref({
  sortBy: 'date',
  descending: true,
  page: 1,
  rowsPerPage: 16,
  rowsNumber: 550,
});

/** filtering **/
const dateRange = ref({ from: null, to: null });
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
const selectedTypes: Ref<EventType[]> = ref([]);

const availableTypes = Object.values(EventType);
function eventTypeTitle(eventType: EventType): string {
  return EventTypeTitle[eventType] ?? eventType;
}

const dateStart = computed(() => {
  const val = dateRange.value;
  if (!val) {
    return null;
  }

  if (!val.hasOwnProperty('from')) {
    return val;
  }

  if (val.from) {
    return val.from;
  }

  return null;
});

const dateEnd = computed(() => {
  const val = dateRange.value;
  if (!val) {
    return null;
  }

  if (!val.hasOwnProperty('to')) {
    return val;
  }

  if (val.to) {
    return val.to;
  }

  return null;
});

const store = useMainStore();

const selectedUsers: Ref<User[]> = ref([]);
const users = computed(() => store.users);

const tableFilter: ComputedRef<EventLogsFilter> = computed(() => ({
  type: selectedTypes.value,
  user_id: selectedUsers.value.map((u) => u.id),
  date_start: dateStart.value,
  date_end: dateEnd.value,
}));

watch(tableFilter, () => {
  loadEventLog(pagination.value?.page, pagination.value?.rowsPerPage);
});

const events = ref<EventLogEntry[]>([]);

async function loadEventLog(page: number, pageSize: number) {
  try {
    const response = await fetchEventsLog(page, pageSize, tableFilter.value);

    const logEntries = response.entities.map((entity) => EventLogEntry.fromResponse(entity));

    events.value.splice(0, events.value.length, ...logEntries);

    pagination.value = {
      ...pagination.value,
      page: page,
      rowsPerPage: pageSize,
      rowsNumber: response.total_count,
    };
  } catch (e) {
    console.error(e.toString(), e);
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
    style: 'width: 30px',
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
];

const rowsPerPageOptions = [8, 16, 32, 64];

loadEventLog(pagination.value.page, pagination.value.rowsPerPage);

const onRequest: QTableProps['onRequest'] = (r) => {
  loadEventLog(r.pagination.page, r.pagination.rowsPerPage);
};
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
    <QSelect
      v-model="selectedTypes"
      label="Тип события"
      :options="availableTypes"
      :option-label="eventTypeTitle"
      multiple
    />
    <QSelect
      v-model="selectedUsers"
      label="Пользователь системы"
      :options="users"
      option-label="name"
      multiple
    />
    <QTable
      v-model:pagination="pagination"
      :columns="columns"
      :rows="events"
      :rows-per-page-options="rowsPerPageOptions"
      @request="onRequest"
    />
  </div>
</template>
