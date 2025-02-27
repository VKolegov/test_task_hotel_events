import { createRouter, createWebHistory } from 'vue-router';

import EventsLog from '@/views/EventsLog.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: EventsLog,
    },
  ],
});

export default router;
