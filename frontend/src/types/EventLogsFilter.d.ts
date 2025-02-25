import type {EventType} from "./EventLogType";

export default interface EventLogsFilter {
  type?: EventType[];
  user_id?: number[];
  date_start?: Date;
  date_end?: Date;
}
