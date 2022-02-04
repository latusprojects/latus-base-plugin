import {StepComponent} from "./stepComponent";

export class StepFormComponent {
    _steps = {};
    _formFillers = {};

    _element;

    constructor(id) {
        this._element = document.createElement('div', {is: 'latus-step-form'});
        this._element.id = id;
    }

    build() {
        return this._element;
    }

    rendered() {
        let stepContainer = this._element.querySelector('.step-form-steps');

        for (let [name, step] of Object.entries(this._steps)) {
            stepContainer.appendChild(step.build());
            step.rendered();
        }

        if (this._formFillers) {
            for (let [selector, callback] of Object.entries(this._formFillers)) {
                callback(this, this._element.querySelectorAll(selector));
            }
        }
    }

    addStep(name, label) {
        this._steps[name] = new StepComponent(this, name, label);

        return this._steps[name];
    }

    step(name) {
        return this._steps[name];
    }

    fill(formFillers) {
        this._formFillers = formFillers;

        return this;
    }

    getElement() {
        return this._element;
    }

    finish(targetId) {
        let element = this.build();

        let targetElement = document.getElementById(targetId);

        targetElement.appendChild(element);

        this.rendered();

        return element;
    }

}