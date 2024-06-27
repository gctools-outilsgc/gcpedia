import { html } from "lit";
export type TRoutable = {
    requestUpdate: () => void;
    routes: (params: TParams) => ReturnType<typeof html>;
};
export type TParams = {
    [name: string]: string | number;
};
export type TWindowRouter = {
    _router: Router;
};
export declare class Router {
    routesFor: TRoutable;
    index: string;
    source: string;
    group: string;
    currentHash: string;
    constructor(routesFor: TRoutable);
    link(params: TParams): string;
    outlet(): import("lit-html").TemplateResult<1>;
    private _paramsToLink;
    handleHashChange(): void;
    private _updateProps;
}
//# sourceMappingURL=router.d.ts.map