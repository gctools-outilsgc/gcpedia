export type TTraceHistorySummary = {
    link: string;
    date: string;
    features: string[];
    results: {
        success: number;
        fail: number;
    };
};
export type TPRData = {
    link: string;
    title: string;
    date: string;
};
export declare class DataAccess {
    private latest;
    getLatest(): Promise<string[]>;
    getTracksHistories(): Promise<TTraceHistorySummary[]>;
}
export declare function summarize(file: string): Promise<TTraceHistorySummary>;
//# sourceMappingURL=data-access.d.ts.map