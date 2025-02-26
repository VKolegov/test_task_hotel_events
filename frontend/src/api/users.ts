import type {User} from "@/types/User";
import {baseURL, getRequest} from "./basic_api";


export async function fetchMe(): Promise<User> {
  return await getRequest(`${baseURL}/me`);
}

export async function fetchAllUsers(): Promise<User[]> {
  return await getRequest(`${baseURL}/users`);
}
