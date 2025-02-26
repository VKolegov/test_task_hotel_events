<script setup lang="ts">
import { RouterView } from 'vue-router';
import { QLayout } from 'quasar';
import { useMainStore } from './stores/main';

const store = useMainStore();

store.retrieveAllUsers();
</script>

<template>
  <QLayout>
    <RouterView />
  </QLayout>
</template>

<style scoped></style>
