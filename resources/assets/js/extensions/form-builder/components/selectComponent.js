export class SelectComponent {
    _row;
    _element;
    _onRender;

    _name;
    _label;
    _description;
    _value;
    _disabled;
    _options;

    constructor(row, {name, label, description, classes, type, value, disabled, options}, onRender = null) {
        this._row = row;
        this._onRender = onRender;

        this._name = name;
        this._label = label;
        this._description = description;
        this._value = value;
        this._disabled = disabled;
        this._options = options;

        this._element = document.createElement('div', {is: 'latus-select'});
        this._element.classList.add(...classes);


    }

    rendered() {
        if (this._label) {
            let labelElement = this._element.querySelector('.form-label');
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

        let selectElement = this._element.querySelector('select.form-select');

        selectElement.id = this._name;
        selectElement.setAttribute('name', this._name);

        if (this._disabled) {
            selectElement.classList.add('disabled');
            selectElement.setAttribute('disabled', 'disabled');
        }

        if (this._value) {
            selectElement.value = this._value;
        }

        if (this._options) {
            for (let [value, label] of Object.entries(this._options)) {
                let optionElement = document.createElement('option');
                optionElement.value = value;
                optionElement.innerText = label;
                selectElement.appendChild(optionElement);
            }
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