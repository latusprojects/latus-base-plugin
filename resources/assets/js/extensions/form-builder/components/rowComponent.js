import {InputComponent} from "./inputComponent";
import {SelectComponent} from "./selectComponent";
import {TextareaComponent} from "./textareaComponent";

export class RowComponent {
    _inputs = [];
    _section;

    _rowElement;
    _element;
    _id;
    _label;

    constructor(section, {id, label}) {

        console.log(section);
        this._id = id;
        this._label = label;

        this._rowElement = document.createElement('div', {is: 'latus-row'});

        if (this._label !== null) {
            let labelElement = document.createElement('div');
            labelElement.classList.add('mb-2');
            labelElement.innerHTML = '<span class="border-bottom border-primary">' + this._label + '</span>'

            this._element = document.createElement('div');
            this._element.append(labelElement, this._rowElement);
        }

        this._section = section;
    }

    build() {
        return this._label !== null
            ? this._element
            : this._rowElement;
    }

    rendered() {
        if (this._id !== null) {
            this._rowElement.id = this._id;
        }

        for (let input of this._inputs) {
            if (input instanceof HTMLElement) {
                this._rowElement.appendChild(input);
            } else {
                this._rowElement.appendChild(input.build());
                input.rendered();

                let onRender = input.getOnRender();

                if (onRender) {
                    onRender(input.getElement());
                }
            }
        }
    }

    section() {
        return this._section;
    }

    addElement(element) {

        this._inputs.push(element);

        return this;
    }

    addInput({
                 name,
                 label = null,
                 description = null,
                 classes = ['col-12', 'col-md-4'],
                 type = 'text',
                 value = null,
                 disabled = false,
                 onRender = null,
             }) {
        this._inputs.push(new InputComponent(this, {
                name: name,
                label: label,
                description: description,
                classes: classes,
                type: type,
                value: value,
                disabled: disabled,
            },
            onRender
        ));

        return this;
    }

    addSelect({
                  name,
                  label = null,
                  description = null,
                  classes = ['col-12', 'col-md-4'],
                  value = null,
                  disabled = false,
                  onRender = null,
                  options = null
              }) {
        this._inputs.push(new SelectComponent(this, {
                name: name,
                label: label,
                description: description,
                classes: classes,
                value: value,
                disabled: disabled,
                options: options,
                dataGroup: dataGroup,
                dataName: dataName,
                validatesFor: validatesFor,
            },
            onRender
        ));

        return this;
    }

    addTextarea({
                    name,
                    label = null,
                    description = null,
                    classes = ['col-12', 'col-md-4'],
                    value = null,
                    disabled = false,
                    onRender = null,
                    dataGroup = null,
                    dataName = null,
                    validatesFor = null,
                }) {
        this._inputs.push(new TextareaComponent(this, {
                name: name,
                label: label,
                description: description,
                classes: classes,
                value: value,
                disabled: disabled,
                dataGroup: dataGroup,
                dataName: dataName,
                validatesFor: validatesFor,
            },
            onRender
        ));

        return this;
    }

    finish(targetId) {
        return this._section.finish(targetId);
    }
}