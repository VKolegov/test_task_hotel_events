import { ref, type Ref } from 'vue';
import { defineStore } from 'pinia';
import {fetchAllUsers, fetchMe} from '@/api/users';
import type {User} from '@/types/User';

export const useMainStore = defineStore('main', () => {

  const user : Ref<User | null> = ref(null);

  async function retrieveUser() {
    try {
      user.value = await fetchMe();
    } catch (e) {
      console.error(e);
    }
  }


  const users : Ref<User[]> = ref([]);

  async function retrieveAllUsers() {
    try {
      const response = await fetchAllUsers();
      users.value.splice(0, users.value.length, ...response);
      return users.value;
    } catch(e) {
      console.error(e);
    }
  }


  return {user, users, retrieveUser, retrieveAllUsers};
});
