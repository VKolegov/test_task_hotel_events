export default interface PaginatedResponse<T> {
  current_page: number;
  total_pages: number;
  page_size: number;
  total_count: number;
  entities: T[];
}

