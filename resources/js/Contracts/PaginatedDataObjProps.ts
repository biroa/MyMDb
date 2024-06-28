export interface Props{
    paginatedDataObj: {
        current_page: number,
        from: number,
        last_page:number,
        prev_page:number,
        per_page:number,
        to: number,
        total: number,
        data: ItemData[],
        links:[]
    };
}

export type ItemData = {
    id: number;
    budget: number|null;
    external_id:number|null;
    title: string;
    original_title: string|null;
    overview: string|null;
    popularity: number|null;
    revenue: number|null;
    vote_average: number|null;
    vote_count: number|null;
    user_id: number|null;
}
