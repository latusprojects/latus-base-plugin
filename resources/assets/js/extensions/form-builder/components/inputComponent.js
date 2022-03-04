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
    _dataGroup;
    _dataName;
    _validatesFor;
    _badge;
    _attributes;

    constructor(row, {
        name,
        label,
        description,
        classes,
        type,
        value,
        disabled,
        dataGroup,
        dataName,
        validatesFor,
        badge,
        attributes,
    }, onRender = null) {
        this._row = row;
        this._onRender = onRender;

        this._name = name;
        this._label = label;
        this._description = description;
        this._type = type;
        this._value = value;
        this._disabled = disabled;
        this._dataGroup = dataGroup;
        this._dataName = dataName;
        this._validatesFor = validatesFor;
        this._badge = badge;
        this._attributes = attributes;

        let customElement = 'input';

        if (this._attributes && this._attributes.hasOwnProperty('is')) {
            customElement = this._attributes.is;
            delete this._attributes.is;
        }

        if (badge !== null) {
            this._element = document.createElement('div', {is: 'latus-input-group'});
        } else {
            this._element = document.createElement('div', {is: 'latus-input'});
        }

        this._element.setAttribute('data-latus-is', customElement);

        this._element.classList.add(...classes);

        this._element.setAttribute('data-type', type);
    }

    rendered() {
        if (this._badge !== null) {
            let badgeElement = document.createElement('span');
            badgeElement.classList.add('input-group-text');
            badgeElement.innerText = this._badge.label;

            if (this._badge.pos === 'right') {
                this._element.querySelector('.input-group').appendChild(badgeElement);
            } else {
                this._element.querySelector('.input-group').prepend(badgeElement);
            }
        }

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

        if (this._dataGroup !== null) {
            inputElement.setAttribute('data-latus-group', this._dataGroup);
        }

        if (this._dataName !== null) {
            inputElement.setAttribute('data-latus-name', this._dataName);
        }

        if (this._validatesFor !== null) {
            inputElement.setAttribute('data-latus-validates-for', this._validatesFor);
        }

        if (this._disabled) {
            inputElement.classList.add('disabled');
            inputElement.setAttribute('disabled', 'disabled');
        }

        if (this._value) {
            inputElement.value = this._value;
        }

        if (this._attributes) {
            for (const [key, value] of Object.entries(this._attributes)) {
                inputElement.setAttribute(key, value);
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