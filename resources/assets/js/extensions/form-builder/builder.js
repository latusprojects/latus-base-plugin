import {StepFormWrapper} from "./components/elements/stepFormWrapper";
import {Step} from "./components/elements/step";
import {Section} from "./components/elements/section";
import {StepButton} from "./components/elements/stepButton";
import {StepFormComponent} from "./components/stepFormComponent";
import {Row} from "./components/elements/row";
import {Input} from "./components/elements/input";
import {Select} from "./components/elements/select";
import {MetaMenu} from "./components/elements/metaMenu";
import {Textarea} from "./components/elements/textarea";
import {Button} from "./components/elements/button";
import {InputGroup} from "./components/elements/inputGroup";

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
            window.customElements.define('latus-input-group', InputGroup, {extends: 'div'});
            window.customElements.define('latus-select', Select, {extends: 'div'});
            window.customElements.define('latus-meta-menu', MetaMenu, {extends: 'div'});
            window.customElements.define('latus-textarea', Textarea, {extends: 'div'});
            window.customElements.define('latus-button', Button, {extends: 'button'});
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
            customElements.whenDefined('latus-input-group'),
            customElements.whenDefined('latus-select'),
            customElements.whenDefined('latus-meta-menu'),
            customElements.whenDefined('latus-textarea'),
            customElements.whenDefined('latus-button'),
        ]);
    }

    form() {

    }

    stepForm(id) {
        return new StepFormComponent(id);
    }
}