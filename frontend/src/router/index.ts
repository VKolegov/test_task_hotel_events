import { createRouter, createWebHistory } from 'vue-router'
import EventsLogList from "@/components/EventsLogList.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
  {
    path: '/',
    component: EventsLogList,
  }
  ],
})

export default router
