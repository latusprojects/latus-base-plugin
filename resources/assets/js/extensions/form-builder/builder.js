import {StepFormWrapper} from "./components/elements/stepFormWrapper";
import {Step} from "./components/elements/step";
import {Section} from "./components/elements/section";
import {StepButton} from "./components/elements/stepButton";
import {StepFormComponent} from "./components/stepFormComponent";
import {Row} from "./components/elements/row";
import {Input} from "./components/elements/input";
import {Select} from "./components/elements/select";

export class Builder {

    static components_defined = false;

    constructor() {
        this._defineComponents();
    }

    _defineComponents() {
        if (!Builder.components_defined) {
            window.customElements.define('latus-step-form', StepFormWrapper, {extends: 'div'});
            window.customElements.define('latus-step', Step, {extends: 'div'});
            window.customElements.define('latus-step-button', StepButton, {extends: 'li'});
            window.customElements.define('latus-section', Section, {extends: 'div'});
            window.customElements.define('latus-row', Row, {extends: 'div'});
            window.customElements.define('latus-input', Input, {extends: 'div'});
            window.customElements.define('latus-select', Select, {extends: 'div'});
            Builder.components_defined = true;
        }
    }

    async ready() {
        return await Promise.all([
            customElements.whenDefined('latus-step-form'),
            customElements.whenDefined('latus-step'),
            customElements.whenDefined('latus-step-button'),
            customElements.whenDefined('latus-section'),
            customElements.whenDefined('latus-row'),
            customElements.whenDefined('latus-input'),
            customElements.whenDefined('latus-select'),
        ]);
    }

    form() {

    }

    stepForm(id) {
        return new StepFormComponent(id);
    }
}