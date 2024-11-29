export interface PaginationResult<T> {
    data:          T[];
    path:          string;
    per_page:      number;
    next_cursor:   string;
    next_page_url: string;
    prev_cursor:   null;
    prev_page_url: null;
}