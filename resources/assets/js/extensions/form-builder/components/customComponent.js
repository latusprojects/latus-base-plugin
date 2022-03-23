export class CustomComponent {
    _row;
    _element;
    _onRender;

    _name;
    _elementName;
    _label;
    _classes;
    _dataGroup;
    _dataName;
    _validatesFor;
    _attributes;
    _append;

    constructor(row, {
        name,
        elementName,
        label,
        classes,
        dataGroup,
        dataName,
        validatesFor,
        attributes,
        tagName,
        append,
    }, onRender = null) {
        this._row = row;
        this._onRender = onRender;

        this._name = name;
        this._elementName = elementName;
        this._label = label;
        this._classes = classes;
        this._dataGroup = dataGroup;
        this._dataName = dataName;
        this._validatesFor = validatesFor;
        this._attributes = attributes;
        this._append = append;

        this._element = document.createElement(tagName ?? 'div', {is: this._elementName});

        if (this._classes) {
            this._element.classList.add(...classes);
        }

        if (this._attributes) {
            for (const [key, value] of Object.entries(this._attributes)) {
                this._element.setAttribute(key, value);
            }
        }
    }

    rendered() {


        if (this._label) {
            let labelElement = this._element.querySelector('label.js-latus-input-label');

            if (labelElement) {
                labelElement.innerText = this._label;
            }
        }

        if (this._validatesFor !== null) {
            let validationElement = this._element.querySelector('.js-latus-input-validation');

            if (validationElement) {
                validationElement.setAttribute('data-latus-validates-for', this._validatesFor);
            }
        }

        let inputElement = this._element.querySelector('.js-latus-input');

        if (inputElement) {
            inputElement.setAttribute('id', this._name);
            inputElement.setAttribute('name', this._name);

            if (this._dataGroup !== null) {
                inputElement.setAttribute('data-latus-group', this._dataGroup);
            }

            if (this._dataName !== null) {
                inputElement.setAttribute('data-latus-name', this._dataName);
            }
        }

        if (this._append) {
            this._element.append(this._append);
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