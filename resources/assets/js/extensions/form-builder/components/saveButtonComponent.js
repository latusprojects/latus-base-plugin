export class SaveButtonComponent {
    _formId;
    _label;

    _element;

    constructor(formId, label) {
        this._formId = formId;
        this._label = label;

        this._element = document.createElement('button', {is: 'latus-button'});

        this._element.setAttribute('type', 'submit');

        this._element.classList.add('btn-primary', 'js-latus-save');
        this._element.innerText = this._label;
    }

    rendered() {
        this._element.setAttribute('data-form-id', this._formId);
    }

    build() {
        return this._element;
    }
}