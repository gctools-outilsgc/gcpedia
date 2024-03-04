import { LitElement, TemplateResult } from 'lit';
import './json-view-clipboard.js';
import { TFoundHistories } from '@haibun/core/build/lib/LogHistory.js';
import { THistoryWithMeta, TLogHistoryWithArtifact, TLogHistory, TArtifactMessageContext } from '@haibun/core/build/lib/interfaces/logger.js';
export declare class ReviewsGroups extends LitElement {
    foundHistories?: TFoundHistories;
    group?: string;
    index?: string;
    static styles: import("lit").CSSResult[];
    render(): TemplateResult<1>;
}
declare const views: readonly ["results", "everything", "documentation"];
type TView = typeof views[number];
export declare class AReview extends LitElement {
    reviewLD?: THistoryWithMeta;
    detail?: object;
    view: TView;
    static styles: import("lit").CSSResult[];
    artifacts: TLogHistoryWithArtifact[];
    videoOverview: TLogHistoryWithArtifact | undefined;
    connectedCallback(): Promise<void>;
    currentFilter: (h: TLogHistory) => boolean | import("@haibun/core/build/lib/interfaces/logger.js").TLogHistoryWithExecutorTopic;
    render(): TemplateResult<1>;
    handleShowDetail(event: CustomEvent): void;
    videoDetail(): void;
    updated(changedProperties: Map<string | number | symbol, unknown>): void;
    initializeFromCookie(): void;
    saveToCookie(): void;
    getCookie(name: string): string | null;
}
export declare class ReviewStep extends LitElement {
    logHistory?: TLogHistory;
    showLogLevel: boolean;
    static styles: import("lit").CSSResult[];
    render(): TemplateResult<1>;
    selectMessage(): void;
    reportDetail(artifactContext: TArtifactMessageContext): TemplateResult<1>;
    showDetail(html: TemplateResult): void;
    loggerButton(message: string): TemplateResult<1>;
}
export {};
//# sourceMappingURL=components.d.ts.map