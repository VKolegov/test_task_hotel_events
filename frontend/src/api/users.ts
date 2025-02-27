import { baseURL, getRequest } from './basic_api';

import type { User } from '@/types/User';

export async function fetchMe(): Promise<User> {
  return await getRequest(`${baseURL}/me`);
}

export async function fetchAllUsers(): Promise<User[]> {
  return await getRequest(`${baseURL}/users`);
}
