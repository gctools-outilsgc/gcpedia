/**
 * Bundle of haibun-reviews-dashboard
 * Generated: 2024-05-09
 * Version: 1.40.5
 * Dependencies:
 *
 * tslib -- 2.6.2
 *
 * @lit/reactive-element -- 2.0.2
 *
 * lit-html -- 3.1.0
 *
 * lit-element -- 4.0.2
 *
 * @alenaksu/json-viewer -- 2.0.1
 *
 * @haibun/core -- 1.32.9
 */

/******************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */
/* global Reflect, Promise, SuppressedError, Symbol */


function __decorate(decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
}

typeof SuppressedError === "function" ? SuppressedError : function (error, suppressed, message) {
    var e = new Error(message);
    return e.name = "SuppressedError", e.error = error, e.suppressed = suppressed, e;
};

/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const t$7=globalThis,e$9=t$7.ShadowRoot&&(void 0===t$7.ShadyCSS||t$7.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,s$7=Symbol(),o$9=new WeakMap;let n$9 = class n{constructor(t,e,o){if(this._$cssResult$=!0,o!==s$7)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e;}get styleSheet(){let t=this.o;const s=this.t;if(e$9&&void 0===t){const e=void 0!==s&&1===s.length;e&&(t=o$9.get(s)),void 0===t&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),e&&o$9.set(s,t));}return t}toString(){return this.cssText}};const r$7=t=>new n$9("string"==typeof t?t:t+"",void 0,s$7),i$7=(t,...e)=>{const o=1===t.length?t[0]:e.reduce(((e,s,o)=>e+(t=>{if(!0===t._$cssResult$)return t.cssText;if("number"==typeof t)return t;throw Error("Value passed to 'css' function must be a 'css' function result: "+t+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+t[o+1]),t[0]);return new n$9(o,t,s$7)},S$3=(s,o)=>{if(e$9)s.adoptedStyleSheets=o.map((t=>t instanceof CSSStyleSheet?t:t.styleSheet));else for(const e of o){const o=document.createElement("style"),n=t$7.litNonce;void 0!==n&&o.setAttribute("nonce",n),o.textContent=e.cssText,s.appendChild(o);}},c$5=e$9?t=>t:t=>t instanceof CSSStyleSheet?(t=>{let e="";for(const s of t.cssRules)e+=s.cssText;return r$7(e)})(t):t;

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:i$6,defineProperty:e$8,getOwnPropertyDescriptor:r$6,getOwnPropertyNames:h$4,getOwnPropertySymbols:o$8,getPrototypeOf:n$8}=Object,a$4=globalThis,c$4=a$4.trustedTypes,l$5=c$4?c$4.emptyScript:"",p$3=a$4.reactiveElementPolyfillSupport,d$4=(t,s)=>t,u$4={toAttribute(t,s){switch(s){case Boolean:t=t?l$5:null;break;case Object:case Array:t=null==t?t:JSON.stringify(t);}return t},fromAttribute(t,s){let i=t;switch(s){case Boolean:i=null!==t;break;case Number:i=null===t?null:Number(t);break;case Object:case Array:try{i=JSON.parse(t);}catch(t){i=null;}}return i}},f$3=(t,s)=>!i$6(t,s),y$3={attribute:!0,type:String,converter:u$4,reflect:!1,hasChanged:f$3};Symbol.metadata??=Symbol("metadata"),a$4.litPropertyMetadata??=new WeakMap;let b$1 = class b extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??=[]).push(t);}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,s=y$3){if(s.state&&(s.attribute=!1),this._$Ei(),this.elementProperties.set(t,s),!s.noAccessor){const i=Symbol(),r=this.getPropertyDescriptor(t,i,s);void 0!==r&&e$8(this.prototype,t,r);}}static getPropertyDescriptor(t,s,i){const{get:e,set:h}=r$6(this.prototype,t)??{get(){return this[s]},set(t){this[s]=t;}};return {get(){return e?.call(this)},set(s){const r=e?.call(this);h.call(this,s),this.requestUpdate(t,r,i);},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??y$3}static _$Ei(){if(this.hasOwnProperty(d$4("elementProperties")))return;const t=n$8(this);t.finalize(),void 0!==t.l&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties);}static finalize(){if(this.hasOwnProperty(d$4("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(d$4("properties"))){const t=this.properties,s=[...h$4(t),...o$8(t)];for(const i of s)this.createProperty(i,t[i]);}const t=this[Symbol.metadata];if(null!==t){const s=litPropertyMetadata.get(t);if(void 0!==s)for(const[t,i]of s)this.elementProperties.set(t,i);}this._$Eh=new Map;for(const[t,s]of this.elementProperties){const i=this._$Eu(t,s);void 0!==i&&this._$Eh.set(i,t);}this.elementStyles=this.finalizeStyles(this.styles);}static finalizeStyles(s){const i=[];if(Array.isArray(s)){const e=new Set(s.flat(1/0).reverse());for(const s of e)i.unshift(c$5(s));}else void 0!==s&&i.push(c$5(s));return i}static _$Eu(t,s){const i=s.attribute;return !1===i?void 0:"string"==typeof i?i:"string"==typeof t?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev();}_$Ev(){this._$Eg=new Promise((t=>this.enableUpdating=t)),this._$AL=new Map,this._$ES(),this.requestUpdate(),this.constructor.l?.forEach((t=>t(this)));}addController(t){(this._$E_??=new Set).add(t),void 0!==this.renderRoot&&this.isConnected&&t.hostConnected?.();}removeController(t){this._$E_?.delete(t);}_$ES(){const t=new Map,s=this.constructor.elementProperties;for(const i of s.keys())this.hasOwnProperty(i)&&(t.set(i,this[i]),delete this[i]);t.size>0&&(this._$Ep=t);}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return S$3(t,this.constructor.elementStyles),t}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$E_?.forEach((t=>t.hostConnected?.()));}enableUpdating(t){}disconnectedCallback(){this._$E_?.forEach((t=>t.hostDisconnected?.()));}attributeChangedCallback(t,s,i){this._$AK(t,i);}_$EO(t,s){const i=this.constructor.elementProperties.get(t),e=this.constructor._$Eu(t,i);if(void 0!==e&&!0===i.reflect){const r=(void 0!==i.converter?.toAttribute?i.converter:u$4).toAttribute(s,i.type);this._$Em=t,null==r?this.removeAttribute(e):this.setAttribute(e,r),this._$Em=null;}}_$AK(t,s){const i=this.constructor,e=i._$Eh.get(t);if(void 0!==e&&this._$Em!==e){const t=i.getPropertyOptions(e),r="function"==typeof t.converter?{fromAttribute:t.converter}:void 0!==t.converter?.fromAttribute?t.converter:u$4;this._$Em=e,this[e]=r.fromAttribute(s,t.type),this._$Em=null;}}requestUpdate(t,s,i,e=!1,r){if(void 0!==t){if(i??=this.constructor.getPropertyOptions(t),!(i.hasChanged??f$3)(e?r:this[t],s))return;this.C(t,s,i);}!1===this.isUpdatePending&&(this._$Eg=this._$EP());}C(t,s,i){this._$AL.has(t)||this._$AL.set(t,s),!0===i.reflect&&this._$Em!==t&&(this._$Ej??=new Set).add(t);}async _$EP(){this.isUpdatePending=!0;try{await this._$Eg;}catch(t){Promise.reject(t);}const t=this.scheduleUpdate();return null!=t&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[t,s]of this._$Ep)this[t]=s;this._$Ep=void 0;}const t=this.constructor.elementProperties;if(t.size>0)for(const[s,i]of t)!0!==i.wrapped||this._$AL.has(s)||void 0===this[s]||this.C(s,this[s],i);}let t=!1;const s=this._$AL;try{t=this.shouldUpdate(s),t?(this.willUpdate(s),this._$E_?.forEach((t=>t.hostUpdate?.())),this.update(s)):this._$ET();}catch(s){throw t=!1,this._$ET(),s}t&&this._$AE(s);}willUpdate(t){}_$AE(t){this._$E_?.forEach((t=>t.hostUpdated?.())),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t);}_$ET(){this._$AL=new Map,this.isUpdatePending=!1;}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$Eg}shouldUpdate(t){return !0}update(t){this._$Ej&&=this._$Ej.forEach((t=>this._$EO(t,this[t]))),this._$ET();}updated(t){}firstUpdated(t){}};b$1.elementStyles=[],b$1.shadowRootOptions={mode:"open"},b$1[d$4("elementProperties")]=new Map,b$1[d$4("finalized")]=new Map,p$3?.({ReactiveElement:b$1}),(a$4.reactiveElementVersions??=[]).push("2.0.2");

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const t$6=globalThis,i$5=t$6.trustedTypes,s$6=i$5?i$5.createPolicy("lit-html",{createHTML:t=>t}):void 0,e$7="$lit$",h$3=`lit$${(Math.random()+"").slice(9)}$`,o$7="?"+h$3,n$7=`<${o$7}>`,r$5=document,l$4=()=>r$5.createComment(""),c$3=t=>null===t||"object"!=typeof t&&"function"!=typeof t,a$3=Array.isArray,u$3=t=>a$3(t)||"function"==typeof t?.[Symbol.iterator],d$3="[ \t\n\f\r]",f$2=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,v$2=/-->/g,_$1=/>/g,m$2=RegExp(`>|${d$3}(?:([^\\s"'>=/]+)(${d$3}*=${d$3}*(?:[^ \t\n\f\r"'\`<>=]|("|')|))|$)`,"g"),p$2=/'/g,g$2=/"/g,$$1=/^(?:script|style|textarea|title)$/i,y$2=t=>(i,...s)=>({_$litType$:t,strings:i,values:s}),x$1=y$2(1),w$1=Symbol.for("lit-noChange"),T$1=Symbol.for("lit-nothing"),A$1=new WeakMap,E$1=r$5.createTreeWalker(r$5,129);function C$1(t,i){if(!Array.isArray(t)||!t.hasOwnProperty("raw"))throw Error("invalid template strings array");return void 0!==s$6?s$6.createHTML(i):i}const P$1=(t,i)=>{const s=t.length-1,o=[];let r,l=2===i?"<svg>":"",c=f$2;for(let i=0;i<s;i++){const s=t[i];let a,u,d=-1,y=0;for(;y<s.length&&(c.lastIndex=y,u=c.exec(s),null!==u);)y=c.lastIndex,c===f$2?"!--"===u[1]?c=v$2:void 0!==u[1]?c=_$1:void 0!==u[2]?($$1.test(u[2])&&(r=RegExp("</"+u[2],"g")),c=m$2):void 0!==u[3]&&(c=m$2):c===m$2?">"===u[0]?(c=r??f$2,d=-1):void 0===u[1]?d=-2:(d=c.lastIndex-u[2].length,a=u[1],c=void 0===u[3]?m$2:'"'===u[3]?g$2:p$2):c===g$2||c===p$2?c=m$2:c===v$2||c===_$1?c=f$2:(c=m$2,r=void 0);const x=c===m$2&&t[i+1].startsWith("/>")?" ":"";l+=c===f$2?s+n$7:d>=0?(o.push(a),s.slice(0,d)+e$7+s.slice(d)+h$3+x):s+h$3+(-2===d?i:x);}return [C$1(t,l+(t[s]||"<?>")+(2===i?"</svg>":"")),o]};let V$1 = class V{constructor({strings:t,_$litType$:s},n){let r;this.parts=[];let c=0,a=0;const u=t.length-1,d=this.parts,[f,v]=P$1(t,s);if(this.el=V.createElement(f,n),E$1.currentNode=this.el.content,2===s){const t=this.el.content.firstChild;t.replaceWith(...t.childNodes);}for(;null!==(r=E$1.nextNode())&&d.length<u;){if(1===r.nodeType){if(r.hasAttributes())for(const t of r.getAttributeNames())if(t.endsWith(e$7)){const i=v[a++],s=r.getAttribute(t).split(h$3),e=/([.?@])?(.*)/.exec(i);d.push({type:1,index:c,name:e[2],strings:s,ctor:"."===e[1]?k$1:"?"===e[1]?H$1:"@"===e[1]?I$1:R$1}),r.removeAttribute(t);}else t.startsWith(h$3)&&(d.push({type:6,index:c}),r.removeAttribute(t));if($$1.test(r.tagName)){const t=r.textContent.split(h$3),s=t.length-1;if(s>0){r.textContent=i$5?i$5.emptyScript:"";for(let i=0;i<s;i++)r.append(t[i],l$4()),E$1.nextNode(),d.push({type:2,index:++c});r.append(t[s],l$4());}}}else if(8===r.nodeType)if(r.data===o$7)d.push({type:2,index:c});else {let t=-1;for(;-1!==(t=r.data.indexOf(h$3,t+1));)d.push({type:7,index:c}),t+=h$3.length-1;}c++;}}static createElement(t,i){const s=r$5.createElement("template");return s.innerHTML=t,s}};function N$1(t,i,s=t,e){if(i===w$1)return i;let h=void 0!==e?s._$Co?.[e]:s._$Cl;const o=c$3(i)?void 0:i._$litDirective$;return h?.constructor!==o&&(h?._$AO?.(!1),void 0===o?h=void 0:(h=new o(t),h._$AT(t,s,e)),void 0!==e?(s._$Co??=[])[e]=h:s._$Cl=h),void 0!==h&&(i=N$1(t,h._$AS(t,i.values),h,e)),i}let S$2 = class S{constructor(t,i){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=i;}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:i},parts:s}=this._$AD,e=(t?.creationScope??r$5).importNode(i,!0);E$1.currentNode=e;let h=E$1.nextNode(),o=0,n=0,l=s[0];for(;void 0!==l;){if(o===l.index){let i;2===l.type?i=new M$1(h,h.nextSibling,this,t):1===l.type?i=new l.ctor(h,l.name,l.strings,this,t):6===l.type&&(i=new L$1(h,this,t)),this._$AV.push(i),l=s[++n];}o!==l?.index&&(h=E$1.nextNode(),o++);}return E$1.currentNode=r$5,e}p(t){let i=0;for(const s of this._$AV)void 0!==s&&(void 0!==s.strings?(s._$AI(t,s,i),i+=s.strings.length-2):s._$AI(t[i])),i++;}};let M$1 = class M{get _$AU(){return this._$AM?._$AU??this._$Cv}constructor(t,i,s,e){this.type=2,this._$AH=T$1,this._$AN=void 0,this._$AA=t,this._$AB=i,this._$AM=s,this.options=e,this._$Cv=e?.isConnected??!0;}get parentNode(){let t=this._$AA.parentNode;const i=this._$AM;return void 0!==i&&11===t?.nodeType&&(t=i.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,i=this){t=N$1(this,t,i),c$3(t)?t===T$1||null==t||""===t?(this._$AH!==T$1&&this._$AR(),this._$AH=T$1):t!==this._$AH&&t!==w$1&&this._(t):void 0!==t._$litType$?this.g(t):void 0!==t.nodeType?this.$(t):u$3(t)?this.T(t):this._(t);}k(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}$(t){this._$AH!==t&&(this._$AR(),this._$AH=this.k(t));}_(t){this._$AH!==T$1&&c$3(this._$AH)?this._$AA.nextSibling.data=t:this.$(r$5.createTextNode(t)),this._$AH=t;}g(t){const{values:i,_$litType$:s}=t,e="number"==typeof s?this._$AC(t):(void 0===s.el&&(s.el=V$1.createElement(C$1(s.h,s.h[0]),this.options)),s);if(this._$AH?._$AD===e)this._$AH.p(i);else {const t=new S$2(e,this),s=t.u(this.options);t.p(i),this.$(s),this._$AH=t;}}_$AC(t){let i=A$1.get(t.strings);return void 0===i&&A$1.set(t.strings,i=new V$1(t)),i}T(t){a$3(this._$AH)||(this._$AH=[],this._$AR());const i=this._$AH;let s,e=0;for(const h of t)e===i.length?i.push(s=new M(this.k(l$4()),this.k(l$4()),this,this.options)):s=i[e],s._$AI(h),e++;e<i.length&&(this._$AR(s&&s._$AB.nextSibling,e),i.length=e);}_$AR(t=this._$AA.nextSibling,i){for(this._$AP?.(!1,!0,i);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i;}}setConnected(t){void 0===this._$AM&&(this._$Cv=t,this._$AP?.(t));}};let R$1 = class R{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,i,s,e,h){this.type=1,this._$AH=T$1,this._$AN=void 0,this.element=t,this.name=i,this._$AM=e,this.options=h,s.length>2||""!==s[0]||""!==s[1]?(this._$AH=Array(s.length-1).fill(new String),this.strings=s):this._$AH=T$1;}_$AI(t,i=this,s,e){const h=this.strings;let o=!1;if(void 0===h)t=N$1(this,t,i,0),o=!c$3(t)||t!==this._$AH&&t!==w$1,o&&(this._$AH=t);else {const e=t;let n,r;for(t=h[0],n=0;n<h.length-1;n++)r=N$1(this,e[s+n],i,n),r===w$1&&(r=this._$AH[n]),o||=!c$3(r)||r!==this._$AH[n],r===T$1?t=T$1:t!==T$1&&(t+=(r??"")+h[n+1]),this._$AH[n]=r;}o&&!e&&this.O(t);}O(t){t===T$1?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"");}};let k$1 = class k extends R$1{constructor(){super(...arguments),this.type=3;}O(t){this.element[this.name]=t===T$1?void 0:t;}};let H$1 = class H extends R$1{constructor(){super(...arguments),this.type=4;}O(t){this.element.toggleAttribute(this.name,!!t&&t!==T$1);}};let I$1 = class I extends R$1{constructor(t,i,s,e,h){super(t,i,s,e,h),this.type=5;}_$AI(t,i=this){if((t=N$1(this,t,i,0)??T$1)===w$1)return;const s=this._$AH,e=t===T$1&&s!==T$1||t.capture!==s.capture||t.once!==s.once||t.passive!==s.passive,h=t!==T$1&&(s===T$1||e);e&&this.element.removeEventListener(this.name,this,s),h&&this.element.addEventListener(this.name,this,t),this._$AH=t;}handleEvent(t){"function"==typeof this._$AH?this._$AH.call(this.options?.host??this.element,t):this._$AH.handleEvent(t);}};let L$1 = class L{constructor(t,i,s){this.element=t,this.type=6,this._$AN=void 0,this._$AM=i,this.options=s;}get _$AU(){return this._$AM._$AU}_$AI(t){N$1(this,t);}};const Z$1=t$6.litHtmlPolyfillSupport;Z$1?.(V$1,M$1),(t$6.litHtmlVersions??=[]).push("3.1.0");const j=(t,i,s)=>{const e=s?.renderBefore??i;let h=e._$litPart$;if(void 0===h){const t=s?.renderBefore??null;e._$litPart$=h=new M$1(i.insertBefore(l$4(),t),t,void 0,s??{});}return h._$AI(t),h};

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let s$5 = class s extends b$1{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0;}createRenderRoot(){const t=super.createRenderRoot();return this.renderOptions.renderBefore??=t.firstChild,t}update(t){const i=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=j(i,this.renderRoot,this.renderOptions);}connectedCallback(){super.connectedCallback(),this._$Do?.setConnected(!0);}disconnectedCallback(){super.disconnectedCallback(),this._$Do?.setConnected(!1);}render(){return w$1}};s$5._$litElement$=!0,s$5[("finalized")]=!0,globalThis.litElementHydrateSupport?.({LitElement:s$5});const r$4=globalThis.litElementPolyfillSupport;r$4?.({LitElement:s$5});(globalThis.litElementVersions??=[]).push("4.0.2");

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const t$5=t=>(e,o)=>{void 0!==o?o.addInitializer((()=>{customElements.define(t,e);})):customElements.define(t,e);};

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const o$6={attribute:!0,type:String,converter:u$4,reflect:!1,hasChanged:f$3},r$3=(t=o$6,e,r)=>{const{kind:n,metadata:i}=r;let s=globalThis.litPropertyMetadata.get(i);if(void 0===s&&globalThis.litPropertyMetadata.set(i,s=new Map),s.set(r.name,t),"accessor"===n){const{name:o}=r;return {set(r){const n=e.get.call(this);e.set.call(this,r),this.requestUpdate(o,n,t);},init(e){return void 0!==e&&this.C(o,void 0,t),e}}}if("setter"===n){const{name:o}=r;return function(r){const n=this[o];e.call(this,r),this.requestUpdate(o,n,t);}}throw Error("Unsupported decorator location: "+n)};function n$6(t){return (e,o)=>"object"==typeof o?r$3(t,e,o):((t,e,o)=>{const r=e.hasOwnProperty(o);return e.constructor.createProperty(o,r?{...t,wrapped:!0}:t),r?Object.getOwnPropertyDescriptor(e,o):void 0})(t,e,o)}

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const t$4={ATTRIBUTE:1,CHILD:2,PROPERTY:3,BOOLEAN_ATTRIBUTE:4,EVENT:5,ELEMENT:6},e$6=t=>(...e)=>({_$litDirective$:t,values:e});let i$4 = class i{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,e,i){this._$Ct=t,this._$AM=e,this._$Ci=i;}_$AS(t,e){return this.update(t,e)}update(t,e){return this.render(...e)}};

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let e$5 = class e extends i$4{constructor(i){if(super(i),this.et=T$1,i.type!==t$4.CHILD)throw Error(this.constructor.directiveName+"() can only be used in child bindings")}render(r){if(r===T$1||null==r)return this.vt=void 0,this.et=r;if(r===w$1)return r;if("string"!=typeof r)throw Error(this.constructor.directiveName+"() called with a non-string value");if(r===this.et)return this.vt;this.et=r;const s=[r];return s.raw=s,this.vt={_$litType$:this.constructor.resultType,strings:s,values:[]}}};e$5.directiveName="unsafeHTML",e$5.resultType=1;const o$5=e$6(e$5);

/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const t$3=window,e$4=t$3.ShadowRoot&&(void 0===t$3.ShadyCSS||t$3.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,s$4=Symbol(),n$5=new WeakMap;let o$4 = class o{constructor(t,e,n){if(this._$cssResult$=!0,n!==s$4)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e;}get styleSheet(){let t=this.o;const s=this.t;if(e$4&&void 0===t){const e=void 0!==s&&1===s.length;e&&(t=n$5.get(s)),void 0===t&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),e&&n$5.set(s,t));}return t}toString(){return this.cssText}};const r$2=t=>new o$4("string"==typeof t?t:t+"",void 0,s$4),i$3=(t,...e)=>{const n=1===t.length?t[0]:e.reduce(((e,s,n)=>e+(t=>{if(!0===t._$cssResult$)return t.cssText;if("number"==typeof t)return t;throw Error("Value passed to 'css' function must be a 'css' function result: "+t+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+t[n+1]),t[0]);return new o$4(n,t,s$4)},S$1=(s,n)=>{e$4?s.adoptedStyleSheets=n.map((t=>t instanceof CSSStyleSheet?t:t.styleSheet)):n.forEach((e=>{const n=document.createElement("style"),o=t$3.litNonce;void 0!==o&&n.setAttribute("nonce",o),n.textContent=e.cssText,s.appendChild(n);}));},c$2=e$4?t=>t:t=>t instanceof CSSStyleSheet?(t=>{let e="";for(const s of t.cssRules)e+=s.cssText;return r$2(e)})(t):t;

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */var s$3;const e$3=window,r$1=e$3.trustedTypes,h$2=r$1?r$1.emptyScript:"",o$3=e$3.reactiveElementPolyfillSupport,n$4={toAttribute(t,i){switch(i){case Boolean:t=t?h$2:null;break;case Object:case Array:t=null==t?t:JSON.stringify(t);}return t},fromAttribute(t,i){let s=t;switch(i){case Boolean:s=null!==t;break;case Number:s=null===t?null:Number(t);break;case Object:case Array:try{s=JSON.parse(t);}catch(t){s=null;}}return s}},a$2=(t,i)=>i!==t&&(i==i||t==t),l$3={attribute:!0,type:String,converter:n$4,reflect:!1,hasChanged:a$2},d$2="finalized";let u$2 = class u extends HTMLElement{constructor(){super(),this._$Ei=new Map,this.isUpdatePending=!1,this.hasUpdated=!1,this._$El=null,this._$Eu();}static addInitializer(t){var i;this.finalize(),(null!==(i=this.h)&&void 0!==i?i:this.h=[]).push(t);}static get observedAttributes(){this.finalize();const t=[];return this.elementProperties.forEach(((i,s)=>{const e=this._$Ep(s,i);void 0!==e&&(this._$Ev.set(e,s),t.push(e));})),t}static createProperty(t,i=l$3){if(i.state&&(i.attribute=!1),this.finalize(),this.elementProperties.set(t,i),!i.noAccessor&&!this.prototype.hasOwnProperty(t)){const s="symbol"==typeof t?Symbol():"__"+t,e=this.getPropertyDescriptor(t,s,i);void 0!==e&&Object.defineProperty(this.prototype,t,e);}}static getPropertyDescriptor(t,i,s){return {get(){return this[i]},set(e){const r=this[t];this[i]=e,this.requestUpdate(t,r,s);},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)||l$3}static finalize(){if(this.hasOwnProperty(d$2))return !1;this[d$2]=!0;const t=Object.getPrototypeOf(this);if(t.finalize(),void 0!==t.h&&(this.h=[...t.h]),this.elementProperties=new Map(t.elementProperties),this._$Ev=new Map,this.hasOwnProperty("properties")){const t=this.properties,i=[...Object.getOwnPropertyNames(t),...Object.getOwnPropertySymbols(t)];for(const s of i)this.createProperty(s,t[s]);}return this.elementStyles=this.finalizeStyles(this.styles),!0}static finalizeStyles(i){const s=[];if(Array.isArray(i)){const e=new Set(i.flat(1/0).reverse());for(const i of e)s.unshift(c$2(i));}else void 0!==i&&s.push(c$2(i));return s}static _$Ep(t,i){const s=i.attribute;return !1===s?void 0:"string"==typeof s?s:"string"==typeof t?t.toLowerCase():void 0}_$Eu(){var t;this._$E_=new Promise((t=>this.enableUpdating=t)),this._$AL=new Map,this._$Eg(),this.requestUpdate(),null===(t=this.constructor.h)||void 0===t||t.forEach((t=>t(this)));}addController(t){var i,s;(null!==(i=this._$ES)&&void 0!==i?i:this._$ES=[]).push(t),void 0!==this.renderRoot&&this.isConnected&&(null===(s=t.hostConnected)||void 0===s||s.call(t));}removeController(t){var i;null===(i=this._$ES)||void 0===i||i.splice(this._$ES.indexOf(t)>>>0,1);}_$Eg(){this.constructor.elementProperties.forEach(((t,i)=>{this.hasOwnProperty(i)&&(this._$Ei.set(i,this[i]),delete this[i]);}));}createRenderRoot(){var t;const s=null!==(t=this.shadowRoot)&&void 0!==t?t:this.attachShadow(this.constructor.shadowRootOptions);return S$1(s,this.constructor.elementStyles),s}connectedCallback(){var t;void 0===this.renderRoot&&(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),null===(t=this._$ES)||void 0===t||t.forEach((t=>{var i;return null===(i=t.hostConnected)||void 0===i?void 0:i.call(t)}));}enableUpdating(t){}disconnectedCallback(){var t;null===(t=this._$ES)||void 0===t||t.forEach((t=>{var i;return null===(i=t.hostDisconnected)||void 0===i?void 0:i.call(t)}));}attributeChangedCallback(t,i,s){this._$AK(t,s);}_$EO(t,i,s=l$3){var e;const r=this.constructor._$Ep(t,s);if(void 0!==r&&!0===s.reflect){const h=(void 0!==(null===(e=s.converter)||void 0===e?void 0:e.toAttribute)?s.converter:n$4).toAttribute(i,s.type);this._$El=t,null==h?this.removeAttribute(r):this.setAttribute(r,h),this._$El=null;}}_$AK(t,i){var s;const e=this.constructor,r=e._$Ev.get(t);if(void 0!==r&&this._$El!==r){const t=e.getPropertyOptions(r),h="function"==typeof t.converter?{fromAttribute:t.converter}:void 0!==(null===(s=t.converter)||void 0===s?void 0:s.fromAttribute)?t.converter:n$4;this._$El=r,this[r]=h.fromAttribute(i,t.type),this._$El=null;}}requestUpdate(t,i,s){let e=!0;void 0!==t&&(((s=s||this.constructor.getPropertyOptions(t)).hasChanged||a$2)(this[t],i)?(this._$AL.has(t)||this._$AL.set(t,i),!0===s.reflect&&this._$El!==t&&(void 0===this._$EC&&(this._$EC=new Map),this._$EC.set(t,s))):e=!1),!this.isUpdatePending&&e&&(this._$E_=this._$Ej());}async _$Ej(){this.isUpdatePending=!0;try{await this._$E_;}catch(t){Promise.reject(t);}const t=this.scheduleUpdate();return null!=t&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var t;if(!this.isUpdatePending)return;this.hasUpdated,this._$Ei&&(this._$Ei.forEach(((t,i)=>this[i]=t)),this._$Ei=void 0);let i=!1;const s=this._$AL;try{i=this.shouldUpdate(s),i?(this.willUpdate(s),null===(t=this._$ES)||void 0===t||t.forEach((t=>{var i;return null===(i=t.hostUpdate)||void 0===i?void 0:i.call(t)})),this.update(s)):this._$Ek();}catch(t){throw i=!1,this._$Ek(),t}i&&this._$AE(s);}willUpdate(t){}_$AE(t){var i;null===(i=this._$ES)||void 0===i||i.forEach((t=>{var i;return null===(i=t.hostUpdated)||void 0===i?void 0:i.call(t)})),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t);}_$Ek(){this._$AL=new Map,this.isUpdatePending=!1;}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$E_}shouldUpdate(t){return !0}update(t){void 0!==this._$EC&&(this._$EC.forEach(((t,i)=>this._$EO(i,this[i],t))),this._$EC=void 0),this._$Ek();}updated(t){}firstUpdated(t){}};u$2[d$2]=!0,u$2.elementProperties=new Map,u$2.elementStyles=[],u$2.shadowRootOptions={mode:"open"},null==o$3||o$3({ReactiveElement:u$2}),(null!==(s$3=e$3.reactiveElementVersions)&&void 0!==s$3?s$3:e$3.reactiveElementVersions=[]).push("1.6.3");

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
var t$2;const i$2=window,s$2=i$2.trustedTypes,e$2=s$2?s$2.createPolicy("lit-html",{createHTML:t=>t}):void 0,o$2="$lit$",n$3=`lit$${(Math.random()+"").slice(9)}$`,l$2="?"+n$3,h$1=`<${l$2}>`,r=document,u$1=()=>r.createComment(""),d$1=t=>null===t||"object"!=typeof t&&"function"!=typeof t,c$1=Array.isArray,v$1=t=>c$1(t)||"function"==typeof(null==t?void 0:t[Symbol.iterator]),a$1="[ \t\n\f\r]",f$1=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,_=/-->/g,m$1=/>/g,p$1=RegExp(`>|${a$1}(?:([^\\s"'>=/]+)(${a$1}*=${a$1}*(?:[^ \t\n\f\r"'\`<>=]|("|')|))|$)`,"g"),g$1=/'/g,$=/"/g,y$1=/^(?:script|style|textarea|title)$/i,w=t=>(i,...s)=>({_$litType$:t,strings:i,values:s}),x=w(1),T=Symbol.for("lit-noChange"),A=Symbol.for("lit-nothing"),E=new WeakMap,C=r.createTreeWalker(r,129,null,!1);function P(t,i){if(!Array.isArray(t)||!t.hasOwnProperty("raw"))throw Error("invalid template strings array");return void 0!==e$2?e$2.createHTML(i):i}const V=(t,i)=>{const s=t.length-1,e=[];let l,r=2===i?"<svg>":"",u=f$1;for(let i=0;i<s;i++){const s=t[i];let d,c,v=-1,a=0;for(;a<s.length&&(u.lastIndex=a,c=u.exec(s),null!==c);)a=u.lastIndex,u===f$1?"!--"===c[1]?u=_:void 0!==c[1]?u=m$1:void 0!==c[2]?(y$1.test(c[2])&&(l=RegExp("</"+c[2],"g")),u=p$1):void 0!==c[3]&&(u=p$1):u===p$1?">"===c[0]?(u=null!=l?l:f$1,v=-1):void 0===c[1]?v=-2:(v=u.lastIndex-c[2].length,d=c[1],u=void 0===c[3]?p$1:'"'===c[3]?$:g$1):u===$||u===g$1?u=p$1:u===_||u===m$1?u=f$1:(u=p$1,l=void 0);const w=u===p$1&&t[i+1].startsWith("/>")?" ":"";r+=u===f$1?s+h$1:v>=0?(e.push(d),s.slice(0,v)+o$2+s.slice(v)+n$3+w):s+n$3+(-2===v?(e.push(void 0),i):w);}return [P(t,r+(t[s]||"<?>")+(2===i?"</svg>":"")),e]};class N{constructor({strings:t,_$litType$:i},e){let h;this.parts=[];let r=0,d=0;const c=t.length-1,v=this.parts,[a,f]=V(t,i);if(this.el=N.createElement(a,e),C.currentNode=this.el.content,2===i){const t=this.el.content,i=t.firstChild;i.remove(),t.append(...i.childNodes);}for(;null!==(h=C.nextNode())&&v.length<c;){if(1===h.nodeType){if(h.hasAttributes()){const t=[];for(const i of h.getAttributeNames())if(i.endsWith(o$2)||i.startsWith(n$3)){const s=f[d++];if(t.push(i),void 0!==s){const t=h.getAttribute(s.toLowerCase()+o$2).split(n$3),i=/([.?@])?(.*)/.exec(s);v.push({type:1,index:r,name:i[2],strings:t,ctor:"."===i[1]?H:"?"===i[1]?L:"@"===i[1]?z:k});}else v.push({type:6,index:r});}for(const i of t)h.removeAttribute(i);}if(y$1.test(h.tagName)){const t=h.textContent.split(n$3),i=t.length-1;if(i>0){h.textContent=s$2?s$2.emptyScript:"";for(let s=0;s<i;s++)h.append(t[s],u$1()),C.nextNode(),v.push({type:2,index:++r});h.append(t[i],u$1());}}}else if(8===h.nodeType)if(h.data===l$2)v.push({type:2,index:r});else {let t=-1;for(;-1!==(t=h.data.indexOf(n$3,t+1));)v.push({type:7,index:r}),t+=n$3.length-1;}r++;}}static createElement(t,i){const s=r.createElement("template");return s.innerHTML=t,s}}function S(t,i,s=t,e){var o,n,l,h;if(i===T)return i;let r=void 0!==e?null===(o=s._$Co)||void 0===o?void 0:o[e]:s._$Cl;const u=d$1(i)?void 0:i._$litDirective$;return (null==r?void 0:r.constructor)!==u&&(null===(n=null==r?void 0:r._$AO)||void 0===n||n.call(r,!1),void 0===u?r=void 0:(r=new u(t),r._$AT(t,s,e)),void 0!==e?(null!==(l=(h=s)._$Co)&&void 0!==l?l:h._$Co=[])[e]=r:s._$Cl=r),void 0!==r&&(i=S(t,r._$AS(t,i.values),r,e)),i}class M{constructor(t,i){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=i;}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){var i;const{el:{content:s},parts:e}=this._$AD,o=(null!==(i=null==t?void 0:t.creationScope)&&void 0!==i?i:r).importNode(s,!0);C.currentNode=o;let n=C.nextNode(),l=0,h=0,u=e[0];for(;void 0!==u;){if(l===u.index){let i;2===u.type?i=new R(n,n.nextSibling,this,t):1===u.type?i=new u.ctor(n,u.name,u.strings,this,t):6===u.type&&(i=new Z(n,this,t)),this._$AV.push(i),u=e[++h];}l!==(null==u?void 0:u.index)&&(n=C.nextNode(),l++);}return C.currentNode=r,o}v(t){let i=0;for(const s of this._$AV)void 0!==s&&(void 0!==s.strings?(s._$AI(t,s,i),i+=s.strings.length-2):s._$AI(t[i])),i++;}}class R{constructor(t,i,s,e){var o;this.type=2,this._$AH=A,this._$AN=void 0,this._$AA=t,this._$AB=i,this._$AM=s,this.options=e,this._$Cp=null===(o=null==e?void 0:e.isConnected)||void 0===o||o;}get _$AU(){var t,i;return null!==(i=null===(t=this._$AM)||void 0===t?void 0:t._$AU)&&void 0!==i?i:this._$Cp}get parentNode(){let t=this._$AA.parentNode;const i=this._$AM;return void 0!==i&&11===(null==t?void 0:t.nodeType)&&(t=i.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,i=this){t=S(this,t,i),d$1(t)?t===A||null==t||""===t?(this._$AH!==A&&this._$AR(),this._$AH=A):t!==this._$AH&&t!==T&&this._(t):void 0!==t._$litType$?this.g(t):void 0!==t.nodeType?this.$(t):v$1(t)?this.T(t):this._(t);}k(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}$(t){this._$AH!==t&&(this._$AR(),this._$AH=this.k(t));}_(t){this._$AH!==A&&d$1(this._$AH)?this._$AA.nextSibling.data=t:this.$(r.createTextNode(t)),this._$AH=t;}g(t){var i;const{values:s,_$litType$:e}=t,o="number"==typeof e?this._$AC(t):(void 0===e.el&&(e.el=N.createElement(P(e.h,e.h[0]),this.options)),e);if((null===(i=this._$AH)||void 0===i?void 0:i._$AD)===o)this._$AH.v(s);else {const t=new M(o,this),i=t.u(this.options);t.v(s),this.$(i),this._$AH=t;}}_$AC(t){let i=E.get(t.strings);return void 0===i&&E.set(t.strings,i=new N(t)),i}T(t){c$1(this._$AH)||(this._$AH=[],this._$AR());const i=this._$AH;let s,e=0;for(const o of t)e===i.length?i.push(s=new R(this.k(u$1()),this.k(u$1()),this,this.options)):s=i[e],s._$AI(o),e++;e<i.length&&(this._$AR(s&&s._$AB.nextSibling,e),i.length=e);}_$AR(t=this._$AA.nextSibling,i){var s;for(null===(s=this._$AP)||void 0===s||s.call(this,!1,!0,i);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i;}}setConnected(t){var i;void 0===this._$AM&&(this._$Cp=t,null===(i=this._$AP)||void 0===i||i.call(this,t));}}class k{constructor(t,i,s,e,o){this.type=1,this._$AH=A,this._$AN=void 0,this.element=t,this.name=i,this._$AM=e,this.options=o,s.length>2||""!==s[0]||""!==s[1]?(this._$AH=Array(s.length-1).fill(new String),this.strings=s):this._$AH=A;}get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}_$AI(t,i=this,s,e){const o=this.strings;let n=!1;if(void 0===o)t=S(this,t,i,0),n=!d$1(t)||t!==this._$AH&&t!==T,n&&(this._$AH=t);else {const e=t;let l,h;for(t=o[0],l=0;l<o.length-1;l++)h=S(this,e[s+l],i,l),h===T&&(h=this._$AH[l]),n||(n=!d$1(h)||h!==this._$AH[l]),h===A?t=A:t!==A&&(t+=(null!=h?h:"")+o[l+1]),this._$AH[l]=h;}n&&!e&&this.j(t);}j(t){t===A?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,null!=t?t:"");}}class H extends k{constructor(){super(...arguments),this.type=3;}j(t){this.element[this.name]=t===A?void 0:t;}}const I=s$2?s$2.emptyScript:"";class L extends k{constructor(){super(...arguments),this.type=4;}j(t){t&&t!==A?this.element.setAttribute(this.name,I):this.element.removeAttribute(this.name);}}class z extends k{constructor(t,i,s,e,o){super(t,i,s,e,o),this.type=5;}_$AI(t,i=this){var s;if((t=null!==(s=S(this,t,i,0))&&void 0!==s?s:A)===T)return;const e=this._$AH,o=t===A&&e!==A||t.capture!==e.capture||t.once!==e.once||t.passive!==e.passive,n=t!==A&&(e===A||o);o&&this.element.removeEventListener(this.name,this,e),n&&this.element.addEventListener(this.name,this,t),this._$AH=t;}handleEvent(t){var i,s;"function"==typeof this._$AH?this._$AH.call(null!==(s=null===(i=this.options)||void 0===i?void 0:i.host)&&void 0!==s?s:this.element,t):this._$AH.handleEvent(t);}}class Z{constructor(t,i,s){this.element=t,this.type=6,this._$AN=void 0,this._$AM=i,this.options=s;}get _$AU(){return this._$AM._$AU}_$AI(t){S(this,t);}}const B=i$2.litHtmlPolyfillSupport;null==B||B(N,R),(null!==(t$2=i$2.litHtmlVersions)&&void 0!==t$2?t$2:i$2.litHtmlVersions=[]).push("2.8.0");const D=(t,i,s)=>{var e,o;const n=null!==(e=null==s?void 0:s.renderBefore)&&void 0!==e?e:i;let l=n._$litPart$;if(void 0===l){const t=null!==(o=null==s?void 0:s.renderBefore)&&void 0!==o?o:null;n._$litPart$=l=new R(i.insertBefore(u$1(),t),t,void 0,null!=s?s:{});}return l._$AI(t),l};

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */var l$1,o$1;let s$1 = class s extends u$2{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0;}createRenderRoot(){var t,e;const i=super.createRenderRoot();return null!==(t=(e=this.renderOptions).renderBefore)&&void 0!==t||(e.renderBefore=i.firstChild),i}update(t){const i=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=D(i,this.renderRoot,this.renderOptions);}connectedCallback(){var t;super.connectedCallback(),null===(t=this._$Do)||void 0===t||t.setConnected(!0);}disconnectedCallback(){var t;super.disconnectedCallback(),null===(t=this._$Do)||void 0===t||t.setConnected(!1);}render(){return T}};s$1.finalized=!0,s$1._$litElement$=!0,null===(l$1=globalThis.litElementHydrateSupport)||void 0===l$1||l$1.call(globalThis,{LitElement:s$1});const n$2=globalThis.litElementPolyfillSupport;null==n$2||n$2({LitElement:s$1});(null!==(o$1=globalThis.litElementVersions)&&void 0!==o$1?o$1:globalThis.litElementVersions=[]).push("3.3.3");

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const i$1=(i,e)=>"method"===e.kind&&e.descriptor&&!("value"in e.descriptor)?{...e,finisher(n){n.createProperty(e.key,i);}}:{kind:"field",key:Symbol(),placement:"own",descriptor:{},originalKey:e.key,initializer(){"function"==typeof e.initializer&&(this[e.key]=e.initializer.call(this));},finisher(n){n.createProperty(e.key,i);}},e$1=(i,e,n)=>{e.constructor.createProperty(n,i);};function n$1(n){return (t,o)=>void 0!==o?e$1(n,t,o):i$1(n,t)}

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function t$1(t){return n$1({...t,state:!0})}

/**
 * @license
 * Copyright 2021 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */var n;null!=(null===(n=window.HTMLSlotElement)||void 0===n?void 0:n.prototype.assignedElements)?(o,n)=>o.assignedElements(n):(o,n)=>o.assignedNodes(n).filter((o=>o.nodeType===Node.ELEMENT_NODE));

/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */
const t={ATTRIBUTE:1,CHILD:2,PROPERTY:3,BOOLEAN_ATTRIBUTE:4,EVENT:5,ELEMENT:6},e=t=>(...e)=>({_$litDirective$:t,values:e});class i{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,e,i){this._$Ct=t,this._$AM=e,this._$Ci=i;}_$AS(t,e){return this.update(t,e)}update(t,e){return this.render(...e)}}

/**
 * @license
 * Copyright 2018 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const o=e(class extends i{constructor(t$1){var i;if(super(t$1),t$1.type!==t.ATTRIBUTE||"class"!==t$1.name||(null===(i=t$1.strings)||void 0===i?void 0:i.length)>2)throw Error("`classMap()` can only be used in the `class` attribute and must be the only part in the attribute.")}render(t){return " "+Object.keys(t).filter((i=>t[i])).join(" ")+" "}update(i,[s]){var r,o;if(void 0===this.it){this.it=new Set,void 0!==i.strings&&(this.nt=new Set(i.strings.join(" ").split(/\s/).filter((t=>""!==t))));for(const t in s)s[t]&&!(null===(r=this.nt)||void 0===r?void 0:r.has(t))&&this.it.add(t);return this.render(s)}const e=i.element.classList;this.it.forEach((t=>{t in s||(e.remove(t),this.it.delete(t));}));for(const t in s){const i=!!s[t];i===this.it.has(t)||(null===(o=this.nt)||void 0===o?void 0:o.has(t))||(i?(e.add(t),this.it.add(t)):(e.remove(t),this.it.delete(t)));}return T}});

function l(e,t,o,r){var n,i=arguments.length,l=i<3?t:null===r?r=Object.getOwnPropertyDescriptor(t,o):r;if("object"==typeof Reflect&&"function"==typeof Reflect.decorate)l=Reflect.decorate(e,t,o,r);else for(var c=e.length-1;c>=0;c--)(n=e[c])&&(l=(i<3?n(l):i>3?n(t,o,l):n(t,o))||l);return i>3&&l&&Object.defineProperty(t,o,l),l}function c(e,t,o,r){return new(o||(o=Promise))((function(n,i){function l(e){try{a(r.next(e));}catch(e){i(e);}}function c(e){try{a(r.throw(e));}catch(e){i(e);}}function a(e){var t;e.done?n(e.value):(t=e.value,t instanceof o?t:new o((function(e){e(t);}))).then(l,c);}a((r=r.apply(e,t||[])).next());}))}function a(e){return null===e?"null":Array.isArray(e)?"array":e.constructor.name.toLowerCase()}function s(e){return e!==Object(e)}function d(e){return !!e&&!!e.nodeType}function u(e){return s(e)||d(e)}function*f(e){const t=[[e,"",[]]];for(;t.length;){const[e,o,r]=t.shift();if(o&&(yield [e,o,r]),!s(e))for(const[n,i]of Object.entries(e))t.push([i,`${o}${o?".":""}${n}`,[...r,o]]);}}const h={fromAttribute:e=>e&&e.trim()?JSON.parse(e):void 0,toAttribute:e=>JSON.stringify(e)},p=e=>void 0!==e,b=(e,t)=>t instanceof RegExp?!!e.match(t):function(e,t){const o=e.split("."),r=t.split("."),n=e=>"**"===e;let i=0,l=0;for(;i<o.length;){const e=r[l];if(e===o[i]||"*"===e)l++,i++;else {if(!n(e))return !1;l++,i=o.length-(r.length-l);}}return l===r.length}(e,t),v=(e,t)=>(o,r)=>{const n={};if(e)for(const[,o,i]of f(r.data))b(o,e)&&(n[o]=t,i.forEach((e=>n[e]=t)));return {expanded:n}},g=e=>()=>({highlight:e}),m=i$3`:host{--background-color:#2a2f3a;--color:#f8f8f2;--string-color:#a3eea0;--number-color:#d19a66;--boolean-color:#4ba7ef;--null-color:#df9cf3;--property-color:#6fb3d2;--preview-color:rgba(222,175,143,0.9);--highlight-color:#7b0000;--font-family:monaco,Consolas,'Lucida Console',monospace;--font-size:1rem;--indent-size:1.5em;--indentguide-size:1px;--indentguide-style:solid;--indentguide-color:#333;--indentguide-color-active:#666;--indentguide:var(--indentguide-size) var(--indentguide-style) var(--indentguide-color);--indentguide-active:var(--indentguide-size) var(--indentguide-style) var(--indentguide-color-active);display:block;background-color:var(--background-color);color:var(--color);font-family:var(--font-family);font-size:var(--font-size)}.preview{color:var(--preview-color)}.null{color:var(--null-color)}.key{color:var(--property-color);display:inline-block}.collapsable:before{display:inline-block;color:var(--color);font-size:.8em;content:'▶';line-height:1em;width:1em;height:1em;text-align:center;transition:transform 195ms ease-out;transform:rotate(90deg);color:var(--property-color)}.collapsable.collapsableCollapsed:before{transform:rotate(0)}.collapsable{cursor:pointer;user-select:none}.string{color:var(--string-color)}.number{color:var(--number-color)}.boolean{color:var(--boolean-color)}ul{padding:0;clear:both}ul,li{list-style:none;position:relative}li ul>li{position:relative;margin-left:var(--indent-size);padding-left:0}ul ul:before{content:'';border-left:var(--indentguide);position:absolute;left:calc(0.5em - var(--indentguide-size));top:.3em;bottom:.3em}ul ul:hover:before{border-left:var(--indentguide-active)}mark{background-color:var(--highlight-color)}`;class y extends s$1{constructor(){super(...arguments),this.state={expanded:{},filtered:{},highlight:null},this.handlePropertyClick=e=>t=>{t.preventDefault(),this.setState(((e,t)=>o=>({expanded:Object.assign(Object.assign({},o.expanded),{[e]:p(t)?!!t:!o.expanded[e]})}))(e));};}setState(e){return c(this,void 0,void 0,(function*(){const t=this.state;this.state=Object.assign(Object.assign({},t),e(t,this));}))}connectedCallback(){this.hasAttribute("data")||p(this.data)||this.setAttribute("data",this.innerText),super.connectedCallback();}expand(e){this.setState(v(e,!0));}expandAll(){this.setState(v("**",!0));}collapseAll(){this.setState(v("**",!1));}collapse(e){this.setState(v(e,!1));}*search(e){for(const[t,o]of f(this.data))u(t)&&String(t).includes(e)&&(this.expand(o),this.updateComplete.then((()=>{const e=this.shadowRoot.querySelector(`[data-path="${o}"]`);e.scrollIntoView({behavior:"smooth",inline:"center",block:"center"}),e.focus();})),this.setState(g(o)),yield {value:t,path:o});this.setState(g(null));}filter(e){var t;this.setState((t=e,(e,o)=>{const r={};if(t)for(const[,e,n]of f(o.data))b(e,t)?(r[e]=!1,n.forEach((e=>r[e]=!1))):r[e]=!0;return {filtered:r}}));}resetFilter(){this.setState((()=>({filtered:{}})));}renderObject(e,t){return x`<ul part="object">${Object.keys(e).map((r=>{const n=e[r],l=t?`${t}.${r}`:r,c=u(n);return x`<li part="property" data-path="${l}" .hidden="${this.state.filtered[l]}"><span part="key" class="${o({key:r,collapsable:!c,collapsableCollapsed:!this.state.expanded[l]})}" @click="${c?null:this.handlePropertyClick(l)}">${r}: </span>${this.renderNode(n,l)}</li>`}))}</ul>`}renderNode(e,t=""){const o=u(e);return !t||this.state.expanded[t]||o?o?this.renderPrimitive(e,t):this.renderObject(e,t):this.renderNodePreview(e)}renderNodePreview(e){return x`<span part="preview" class="preview">${function(e,{nodeCount:t=3,maxLength:o=15}={}){const r=Array.isArray(e),n=Object.keys(e),i=n.slice(0,t),l=[],c=e=>{switch(a(e)){case"object":return 0===Object.keys(e).length?"{ }":"{ ... }";case"array":return 0===e.length?"[ ]":"[ ... ]";case"string":return `"${e.substring(0,o)}${e.length>o?"...":""}"`;default:return String(e)}},s=[];for(const t of i){const o=[],n=e[t];r||o.push(`${t}: `),o.push(c(n)),s.push(o.join(""));}n.length>t&&s.push("..."),l.push(s.join(", "));const d=l.join("");return r?`[ ${d} ]`:`{ ${d} }`}(e)}</span>`}renderPrimitive(e,t){const r=this.state.highlight,n=a(e),i=d(e)?e:x`<span part="primitive primitive-${n}" tabindex="0" class="${a(e)}">${JSON.stringify(e)}</span>`;return t===r?x`<mark part="highlight">${i}</mark>`:i}render(){const e=this.data;return p(e)?this.renderNode(e):null}}y.styles=[m],l([n$1({converter:h,type:Object})],y.prototype,"data",void 0),l([t$1()],y.prototype,"state",void 0);

customElements.define("json-viewer",y);

class ClipboardCopy extends s$5 {
    // black background css
    static styles = i$7 `:host {
        display: block;
        background-color: black;
        padding: 1px;
        }`;
    json = {};
    render() {
        return x$1 `<div>
      <button @click="${this.copyToClipboard}">📋</button>
      <json-viewer .data=${this.json}></json-viewer>
    <div>`;
    }
    copyToClipboard() {
        const jsonText = JSON.stringify(this.json);
        navigator.clipboard.writeText(jsonText)
            .then(() => console.log('JSON copied to clipboard'))
            .catch(err => console.error('Error in copying JSON: ', err));
    }
}
__decorate([
    n$6({ type: String })
], ClipboardCopy.prototype, "json", void 0);
customElements.define('json-view-clipboard', ClipboardCopy);

const controls = i$7 `
ul {
  list-style: none;
}
.artifact::before,
.ok-true::before,
.ok-false::before {
  position: absolute;
  left: -5px; /* Adjust this value to move it further or closer */
}

.artifact::before {
  content: '📦 ';
  position: absolute;
  padding-left: 33px;
}

.artifact-button {
  background-color: #FAD575;
  border-radius: 4px;
}

.styled-select {
  border-radius: 4px;
  border: 1px solid #ccc;
  padding: 5px 10px; /* Padding inside the select box */
  font-size: 16px; /* Font size */
  appearance: none; /* Removes default browser style */
  -webkit-appearance: none; /* For Safari */
  -moz-appearance: none; /* For Firefox */
}

.ok-false::before {
  content: '✕ ';
  color: red;
  position: absolute;
  padding-left: 33px;
}
.ok-true:not(.stepper-prose):not(.stepper-feature)::before {
  content: '✓ ';
  color: green;
  position: absolute;
  padding-left: 33px;
}

.status {
  display: inline-block;
  width: 40px;
  text-align: right;
  color: darkgray;
}

h1,
h2,
h3 {
  display: block;
  margin-block-start: 0.83em;
  margin-block-end: 0.83em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-weight: bold;
}

h2 {
  font-size: 1.5em;
}

.code {
  font-family: monospace;
  white-space: pre-wrap;
}`;
const documentation = i$7 `
  ::part(review-step) {
    line-height: 1.5em;
    margin-top: .5em;
  }
`;

var HANDLER_USAGE;
(function (HANDLER_USAGE) {
    HANDLER_USAGE["EXCLUSIVE"] = "exclusive";
    HANDLER_USAGE["FALLBACK"] = "fallback";
})(HANDLER_USAGE || (HANDLER_USAGE = {}));
const BASE_DOMAINS = [{ name: 'string', resolve: (inp) => inp }];
BASE_DOMAINS.map((b) => b.name);

function findArtifacts(historyWithMeta) {
    return historyWithMeta?.logHistory.filter(h => asArtifact(h));
}
function asActionResult(logHistory) {
    if (logHistory === undefined) {
        return undefined;
    }
    const topic = logHistory.messageContext.topic;
    return topic?.stage === 'Executor' && topic?.result ? logHistory : undefined;
}
function asArtifact(logHistory) {
    return logHistory !== undefined && logHistory?.messageContext?.artifact ? logHistory : undefined;
}
const actionName = (logHistory) => {
    return logHistory.messageContext?.topic?.step?.actions[0].actionName;
};

const VIEW_RESULTS = 'results';
const VIEW_EVERYTHING = 'everything';
const VIEW_DOCUMENTATION = 'documentation';
const router = () => globalThis._router;
let ReviewsGroups = class ReviewsGroups extends s$5 {
    foundHistories;
    group;
    index;
    static styles = [controls];
    render() {
        if (!this.foundHistories)
            return x$1 `<div>No reviews yet</div>`;
        const groups = Object.entries(this.foundHistories?.histories).map(([group, historyWithMeta], index) => {
            const route = router().link({ index, group });
            const titles = historyWithMeta.meta.feature;
            const link = x$1 `<a href=${route} >${titles}</a>`;
            return x$1 `<li class="ok-${historyWithMeta.meta.ok}">${link} </li>`;
        });
        return x$1 `<ul>${groups}</ul>`;
    }
};
__decorate([
    n$6({ type: Object })
], ReviewsGroups.prototype, "foundHistories", void 0);
__decorate([
    n$6({ type: Object })
], ReviewsGroups.prototype, "group", void 0);
__decorate([
    n$6({ type: Object })
], ReviewsGroups.prototype, "index", void 0);
ReviewsGroups = __decorate([
    t$5('reviews-groups')
], ReviewsGroups);
const views = [VIEW_RESULTS, VIEW_EVERYTHING, VIEW_DOCUMENTATION];
let AReview = class AReview extends s$5 {
    reviewLD;
    detail;
    view = VIEW_RESULTS;
    static styles = [controls, i$7 `.review-body {
      display: flex;
    }
    .left-container {
      flex-grow: 1;
    }
    .detail-container {
      width: 640px;
      margin-left: 10px;
    }`];
    artifacts = [];
    videoOverview;
    async connectedCallback() {
        this.artifacts = (findArtifacts(this.reviewLD) || []);
        this.videoOverview = this.artifacts.find(a => a.messageContext.artifact.type === 'video' && a.messageContext.topic.event === 'summary');
        this.videoDetail();
        this.initializeFromCookie();
        await super.connectedCallback();
    }
    currentFilter = (h) => {
        if (this.view === VIEW_EVERYTHING) {
            return true;
        }
        const action = asActionResult(h);
        if (this.view === VIEW_RESULTS) {
            return (!!action || (asArtifact(h) && asArtifact(h)?.messageContext?.topic?.event !== 'debug'));
        }
        // VIEW_DOCUMENTATION
        if (action) {
            const { actionName, stepperName } = action.messageContext.topic.step.actions[0];
            console.log('xx', actionName, stepperName);
            if (['set', 'setAll'].includes(actionName)) {
                return false;
            }
            return true;
        }
        return ((asArtifact(h) || {})?.messageContext?.topic?.event !== 'debug');
    };
    render() {
        const viewStyle = this.view === VIEW_DOCUMENTATION ? x$1 `<style>${documentation}</style>` : T$1;
        if (!this.reviewLD) {
            return x$1 `<h1>No data</h1>`;
        }
        const chooseView = x$1 `
  <select class="styled-select" @change=${(e) => { this.view = e.target.value; this.requestUpdate(); }}>
    ${views.map(option => x$1 `
      <option ?selected=${this.view === option} value=${option}>
        ${option.charAt(0).toUpperCase() + option.slice(1)}
      </option>
    `)}
  </select>
`;
        return this.reviewLD && x$1 `
            <div style="margin-bottom: 4px; padding-left: 20px">View ${chooseView} <label for="show-all-messages"></label></div>
      ${viewStyle}
      <div style="margin-left: 40px">
        <h2 class="ok-${this.reviewLD.meta.ok}">${this.reviewLD.meta.feature}</h2>
        <div class="review-body">
          <div>
          ${(this.reviewLD.logHistory).filter(this.currentFilter).map(h => {
            return x$1 `<review-step class="left-container" ?showLogLevel=${this.view !== VIEW_DOCUMENTATION} .logHistory=${h} @show-detail=${this.handleShowDetail}> .view=${this.view}></review-step>`;
        })}
          </div>
          <div class="detail-container">
            ${this.detail}
          </div>
        </div>
      </div>
    `;
    }
    handleShowDetail(event) {
        const detailHTML = event.detail;
        this.detail = x$1 `${detailHTML}`;
        this.requestUpdate();
    }
    videoDetail() {
        const content = getDetailContent(this.videoOverview?.messageContext.artifact);
        this.detail = x$1 `${content}`;
    }
    updated(changedProperties) {
        if (changedProperties.has('view')) {
            this.saveToCookie();
        }
    }
    initializeFromCookie() {
        const cookieValue = this.getCookie('view');
        console.log('cookie ', cookieValue);
        if (cookieValue !== null) {
            this.view = cookieValue;
        }
    }
    saveToCookie() {
        console.log('saving cookie', this.view);
        document.cookie = `view=${this.view};path=/;max-age=31536000`; // Expires in 1 year
    }
    getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
};
__decorate([
    n$6({ type: Object })
], AReview.prototype, "reviewLD", void 0);
__decorate([
    n$6({ type: Object })
], AReview.prototype, "detail", void 0);
__decorate([
    n$6({ type: String })
], AReview.prototype, "view", void 0);
AReview = __decorate([
    t$5('a-review')
], AReview);
let ReviewStep = class ReviewStep extends s$5 {
    logHistory;
    showLogLevel = true;
    static styles = [controls];
    render() {
        const { logHistory } = this;
        const logArtifact = asArtifact(logHistory);
        const executorResult = asActionResult(logHistory);
        if (logHistory === undefined) {
            return x$1 `<div>No history</div>`;
        }
        const okClasses = [`stepper-${actionName(logHistory)}`];
        const result = executorResult?.messageContext.topic.result.ok;
        if (result !== undefined) {
            okClasses.push(`ok-${result}`);
        }
        else if (logArtifact !== undefined) {
            okClasses.push('artifact');
        }
        const message = executorResult ? executorResult.messageContext.topic.step.in : logHistory.message;
        const loggerDisplay = (!this.showLogLevel || executorResult) ? T$1 : this.loggerButton(logHistory.level);
        const detailButton = logArtifact && this.reportDetail(logArtifact.messageContext);
        const actionClass = 'stepper-' + (actionName(logHistory) || 'unknown');
        return x$1 `<div part="review-step" class="stepper ${actionClass}"><span @click=${this.selectMessage} class=${okClasses.filter(Boolean).join(' ')}>${loggerDisplay} ${message}</span> ${detailButton}</div > `;
    }
    selectMessage() {
        this.showDetail(x$1 `<json-view-clipboard .json=${this.logHistory}></json-view-clipboard>`);
    }
    reportDetail(artifactContext) {
        const content = getDetailContent(artifactContext.artifact);
        return x$1 `<button class="artifact-button" @click=${() => this.showDetail(content)}>${artifactContext.topic.event} ${artifactContext.artifact.type}</button>`;
    }
    showDetail(html) {
        this.dispatchEvent(new CustomEvent('show-detail', { detail: html }));
    }
    loggerButton(message) {
        return x$1 `<span class="status">${message}</span>`;
    }
};
__decorate([
    n$6({ type: Array })
], ReviewStep.prototype, "logHistory", void 0);
__decorate([
    n$6({ type: Boolean })
], ReviewStep.prototype, "showLogLevel", void 0);
ReviewStep = __decorate([
    t$5('review-step')
], ReviewStep);
function getDetailContent(artifact) {
    if (artifact === undefined) {
        return x$1 `<div />`;
    }
    else if (artifact.type === 'html') {
        return x$1 `${o$5(artifact.content)}`;
    }
    else if (artifact.type.startsWith('json')) {
        try {
            return x$1 `<json-view-clipboard .json=${JSON.parse(artifact.content)}></json-view-clipboard>`;
        }
        catch (e) {
            return x$1 `<div class="code">Not JSON: ${artifact.content}</div>`;
        }
    }
    else if (artifact.type === 'video') {
        const videoPath = artifact?.path;
        return videoPath ? x$1 `<video controls width="640"><source src=${videoPath} type="video/mp4"></video>` : x$1 `<div />`;
    }
    else if (artifact.type === 'archive') {
        const archivePath = artifact?.path;
        return x$1 `<a download href=${archivePath}>Download</a>`;
    }
    return x$1 `<img src=${artifact.path} alt=${JSON.stringify(artifact)} />`;
}

const globalStyles = i$7 `
    a {
      text-decoration: none;
    }
    a :hover {
      text-decoration: underline;
    }
    h1 a {
      font-size: 80%;
    }
  `;

class Router {
    routesFor;
    index = '';
    source = '';
    group = '';
    currentHash = '';
    constructor(routesFor) {
        this.routesFor = routesFor;
        globalThis._router = this;
        this._updateProps();
    }
    link(params) {
        return this._paramsToLink({ source: this.source, ...params });
    }
    outlet() {
        return this.routesFor.routes({ index: this.index, group: this.group });
    }
    _paramsToLink(params) {
        const dest = `reviewer.html#source=${this.source}&` + Object.entries(params).map(([key, val]) => `${key}=${val}`).join('&');
        return dest;
    }
    handleHashChange() {
        this.currentHash = window.location.hash;
        this._updateProps(); // Add this line to update properties
        this.routesFor.requestUpdate();
    }
    _updateProps() {
        const { source, group, index } = Object.fromEntries(new URLSearchParams(window.location.hash.substring(1)));
        this.source = source;
        this.group = group;
        this.index = index;
    }
}

let ReviewsShell = class ReviewsShell extends s$5 {
    router = new Router(this);
    foundHistories;
    header = 'Reviews';
    boundHandleHashChange;
    error;
    constructor() {
        super();
    }
    // get source from location
    async _getSource() {
        // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
        if (this.router.source === undefined) {
            this.error = 'source is missing';
            return;
        }
        this.foundHistories = await (await fetch(this.router.source)).json();
    }
    static styles = globalStyles;
    async connectedCallback() {
        await this._getSource();
        this.boundHandleHashChange = this.router.handleHashChange.bind(this.router);
        window.addEventListener('hashchange', this.boundHandleHashChange);
        super.connectedCallback();
    }
    disconnectedCallback() {
        window.removeEventListener('hashchange', this.router.handleHashChange.bind(this));
        super.disconnectedCallback();
    }
    routes(params) {
        if (params.group !== undefined) {
            return x$1 `<a-review .reviewLD=${this.foundHistories?.histories[this.router.group]}></a-review>`;
        }
        return x$1 `<reviews-groups .foundHistories=${this.foundHistories}></reviews-groups>`;
    }
    render() {
        if (this.error) {
            return x$1 `<h1>${this.error}</h1>`;
        }
        if (this.router === undefined || this.foundHistories === undefined) {
            return x$1 `<h1>Loading reviews</h1>`;
        }
        return x$1 `
        <h1>⌂<a href=${this.router.link({})}>${this.header}</a></h1>
        <main>${this.router.outlet()}</main>
    `;
    }
};
__decorate([
    n$6({ type: Object })
], ReviewsShell.prototype, "foundHistories", void 0);
__decorate([
    n$6({ type: String })
], ReviewsShell.prototype, "header", void 0);
__decorate([
    n$6({ type: String })
], ReviewsShell.prototype, "error", void 0);
ReviewsShell = __decorate([
    t$5('reviews-shell')
], ReviewsShell);

export { ReviewsShell };
//# sourceMappingURL=index.js.map
