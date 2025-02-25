<script setup lang="ts">
import {computed, type ComputedRef, ref, type Ref, watch} from 'vue';
import {QTable, QSelect, type QTableProps} from 'quasar';
import {format} from 'date-fns';
import {ru} from 'date-fns/locale';

import EventLogEntry from '@/types/EventLogEntry';
import {EventTypeTitle, EventType} from '@/types/EventLogType';
import HttpError from '@/api/http_error';
import {fetchEventsLog} from '@/api/event_logs';
import type EventLogsFilter from '@/types/EventLogsFilter';


type Pagination = Required<QTableProps['pagination']>;

const pagination: Ref<Pagination> = ref({
  sortBy: 'date',
  descending: true,
  page: 1,
  rowsPerPage: 16,
  rowsNumber: 550,
});

/** filtering **/

const selectedTypes: Ref<EventType[]> = ref([]);

const availableTypes = Object.values(EventType);
function eventTypeTitle(eventType: EventType): string {
  return EventTypeTitle[eventType] ?? eventType;
}

const tableFilter: ComputedRef<EventLogsFilter> = computed(() => ({
  type: selectedTypes.value,
  user_id: [],
  date_start: null,
  date_end: null,
}));

watch(tableFilter, () => {
  loadEventLog(pagination.value?.page, pagination.value?.rowsPerPage);
});


const events = ref<EventLogEntry[]>([]);


async function loadEventLog(page: number, pageSize: number) {
  try {
    const response = await fetchEventsLog(
      page,
      pageSize,
      tableFilter.value,
    );

    const logEntries = response.entities.map(entity => EventLogEntry.fromResponse(entity));

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
    format: (val: Date) => format(val, "dd MMM yyyy  HH:mm", {locale: ru}),
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

const onRequest: QTableProps["onRequest"] = (r) => {
  loadEventLog(r.pagination.page, r.pagination.rowsPerPage);
}

</script>


<template>
  <div>
    <QSelect label="Тип события" v-model="selectedTypes" :options="availableTypes" :option-label="eventTypeTitle"
      multiple />
    <QTable v-model:pagination="pagination" :columns="columns" :rows="events"
      :rows-per-page-options="rowsPerPageOptions" @request="onRequest">

    </QTable>
  </div>
</template>
