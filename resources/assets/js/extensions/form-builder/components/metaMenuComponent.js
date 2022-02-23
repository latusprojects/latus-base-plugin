import {SectionComponent} from "./sectionComponent";

export class MetaMenuComponent {
    _form;
    _label = null;
    _sections = {};

    _element;

    constructor(form) {

        this._element = document.createElement('div', {is: 'latus-meta-menu'});

        this._form = form;
    }

    build() {
        return this._element;
    }

    rendered() {

        let accordion = this.getElement().querySelector('form .accordion');

        for (let [name, section] of Object.entries(this._sections)) {
            accordion.appendChild(section.build());

            section.rendered();
        }
    }

    addSection(name, label = null, isOpen = false, validatesUsing = null) {
        this._sections[name] = new SectionComponent(this, name, label, isOpen, validatesUsing);

        return this._sections[name];
    }

    setLabel(label) {
        this._label = label;
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