import {RowComponent} from "./rowComponent";

export class SectionComponent {
    _step;
    _name;
    _label;
    _isOpen;
    _validatesUsing;

    _rows = [];

    _element;

    constructor(step, name, label, isOpen, validatesUsing) {
        this._step = step;
        this._name = name;
        this._label = label;
        this._isOpen = isOpen;
        this._validatesUsing = validatesUsing;

        this._element = document.createElement('div', {is: 'latus-section'});
        this._element.setAttribute('data-section', name);
    }

    build() {
        return this._element;
    }

    rendered() {
        if (this._validatesUsing) {
            let formattedFieldNames = '';

            this._validatesUsing.forEach(fieldName => {
                formattedFieldNames += '--' + fieldName;
            });

            this._element.setAttribute('data-latus-validates-using', formattedFieldNames);


        }

        if (this._label) {
            let labelElement = this._element.querySelector('.section-label');
            labelElement.innerText = this._label;
        }

        let accordionCollapse = this._element.querySelector('.accordion-collapse');
        accordionCollapse.id = this._name + 'Collapse';

        let accordionButton = this._element.querySelector('.accordion-button');
        accordionButton.setAttribute('data-bs-target', '#' + this._name + 'Collapse');

        if (this._isOpen) {
            accordionCollapse.classList.add('show');
            accordionButton.classList.remove('collapsed');
        }

        for (let row of this._rows) {
            this._element.querySelector('.accordion-body').appendChild(row.build());

            row.rendered();
        }
    }

    step() {
        return this._step;
    }

    addRow(id = null, label = null) {
        let index = this._rows.push(new RowComponent(this, {id: id, label: label}));

        return this._rows[index - 1];
    }

    finish(targetId) {
        return this._step.finish(targetId);
    }
}