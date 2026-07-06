import { LitElement } from 'lit';
import './components.js';
import { Router, TParams } from './router.js';
import { TFoundHistories } from '@haibun/core/build/lib/LogHistory.js';
export declare class ReviewsShell extends LitElement {
    router: Router;
    foundHistories?: TFoundHistories;
    header: string;
    boundHandleHashChange: undefined | (() => void);
    error?: string;
    constructor();
    _getSource(): Promise<void>;
    static styles: import("lit").CSSResult;
    connectedCallback(): Promise<void>;
    disconnectedCallback(): void;
    routes(params: TParams): import("lit-html").TemplateResult<1>;
    render(): import("lit-html").TemplateResult<1>;
}
//# sourceMappingURL=index.d.ts.map