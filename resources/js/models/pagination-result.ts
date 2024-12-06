export interface PaginationResult<T> {
    data:          T[];
    path:          string;
    per_page:      number;
    count:      number;
    next_cursor:   string;
    next_page_url: string;
    prev_cursor:   string;
    prev_page_url: string;
}