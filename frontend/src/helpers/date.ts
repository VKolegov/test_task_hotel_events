import { format } from 'date-fns';
import { ru } from 'date-fns/locale';
export function formatDate(date: Date): string {
  return format(date, 'dd MMM yy', { locale: ru });
}

export function formatDateTime(date: Date): string {
  return format(date, 'dd MMM yyyy HH:mm', { locale: ru });
}
