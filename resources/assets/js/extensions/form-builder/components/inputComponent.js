export class InputComponent {
    _row;
    _element;
    _onRender;

    _name;
    _label;
    _description;
    _type;
    _value;
    _disabled;

    constructor(row, {name, label, description, classes, type, value, disabled}, onRender = null) {
        this._row = row;
        this._onRender = onRender;

        this._name = name;
        this._label = label;
        this._description = description;
        this._type = type;
        this._value = value;
        this._disabled = disabled;

        this._element = document.createElement('div', {is: 'latus-input'});
        this._element.classList.add(...classes);

        this._element.setAttribute('data-type', type);
    }

    rendered() {
        if (this._label) {
            let labelElement = this._element.querySelector('label');
            labelElement.innerText = this._label;
            labelElement.classList.remove('d-none');
            labelElement.setAttribute('for', '#' + this._name);
        }

        if (this._description) {
            let descriptionElement = this._element.querySelector('.form-text');
            descriptionElement.innerText = this._description;
            descriptionElement.classList.remove('d-none');
            descriptionElement.setAttribute('id', this._name + 'HelpBlock');
        }

        let inputElement = this._element.querySelector('input');

        inputElement.setAttribute('id', this._name);
        inputElement.setAttribute('name', this._name);

        if (this._disabled) {
            inputElement.classList.add('disabled');
            inputElement.setAttribute('disabled', 'disabled');
        }

        if (this._value) {
            inputElement.value = this._value;
        }
    }

    getOnRender() {
        return this._onRender;
    }

    build() {
        return this._element;
    }

    finish(targetId) {
        return this._row.finish(targetId);
    }

    getElement() {
        return this._element;
    }
}