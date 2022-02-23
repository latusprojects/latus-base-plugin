export class TextareaComponent {
    _row;
    _element;
    _onRender;

    _name;
    _label;
    _description;
    _value;
    _disabled;
    _dataGroup;
    _dataName;
    _validatesFor;

    constructor(row, {
        name,
        label,
        description,
        classes,
        value,
        disabled,
        dataGroup,
        dataName,
        validatesFor
    }, onRender = null) {
        this._row = row;
        this._onRender = onRender;

        this._name = name;
        this._label = label;
        this._description = description;
        this._value = value;
        this._disabled = disabled;
        this._dataGroup = dataGroup;
        this._dataName = dataName;
        this._validatesFor = validatesFor;

        this._element = document.createElement('div', {is: 'latus-textarea'});
        this._element.classList.add(...classes);
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

        let textareaElement = this._element.querySelector('textarea');

        textareaElement.setAttribute('id', this._name);
        textareaElement.setAttribute('name', this._name);

        if (this._dataGroup !== null) {
            textareaElement.setAttribute('data-latus-group', this._dataGroup);
        }

        if (this._dataName !== null) {
            textareaElement.setAttribute('data-latus-name', this._dataName);
        }

        if (this._validatesFor !== null) {
            textareaElement.setAttribute('data-latus-validates-for', this._validatesFor);
        }

        if (this._disabled) {
            textareaElement.classList.add('disabled');
            textareaElement.setAttribute('disabled', 'disabled');
        }

        if (this._value) {
            textareaElement.value = this._value;
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