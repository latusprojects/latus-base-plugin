import {StepButtonComponent} from "./stepButtonComponent";
import {SectionComponent} from "./sectionComponent";

export class StepComponent {
    _form;
    _label;
    _name;
    _sections = {};

    _element;

    constructor(form, name, label) {

        this._element = document.createElement('div', {is: 'latus-step'});

        this._element.setAttribute('data-step', name);

        this._form = form;
        this._label = label;
        this._name = name;
    }

    build() {
        return this._element;
    }

    rendered() {
        let childCount = this.form().getElement().querySelector('.step-form-steps').children.length;
        let stepButton = new StepButtonComponent(childCount - 1, this.form().getElement().id, this._label);

        if (childCount === 1) {
            this._element.classList.add('active');
        }

        this.form().getElement().querySelector('.step-form-nav').appendChild(stepButton.build());

        stepButton.rendered();

        let accordion = this.getElement().querySelector('form .accordion');

        for (let [name, section] of Object.entries(this._sections)) {
            accordion.appendChild(section.build());

            section.rendered();
        }
    }

    getName() {
        return this._name;
    }

    addSection(name, label = null, isOpen = false) {
        this._sections[name] = new SectionComponent(this, name, label, isOpen);

        return this._sections[name];
    }

    section(name) {
        return this._sections[name];
    }

    form() {
        return this._form;
    }

    getElement() {
        return this._element;
    }

    finish(targetId) {
        return this._form.finish(targetId);
    }
}