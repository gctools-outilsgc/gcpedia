import { TPRData, TTraceHistorySummary } from './data-access.js';
export declare class ReviewOverview extends HTMLElement {
    private dataAccess;
    constructor();
    connectedCallback(): Promise<void>;
    render(prData: TPRData | null, reviewData: TTraceHistorySummary[]): void;
}
//# sourceMappingURL=index.d.ts.map