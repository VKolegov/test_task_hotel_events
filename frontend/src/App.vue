<script setup lang="ts">
import { QLayout, QPageContainer } from 'quasar';
import { RouterView } from 'vue-router';

import { useMainStore } from './stores/main';

const store = useMainStore();

store.retrieveAllUsers();
</script>

<template>
  <QLayout>
    <QPageContainer>
      <RouterView />
    </QPageContainer>
  </QLayout>
</template>

<style scoped></style>
