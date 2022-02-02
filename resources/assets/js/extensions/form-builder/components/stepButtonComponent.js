export class StepButtonComponent {
    _stepIndex;
    _formId;
    _label;

    _element;

    constructor(stepIndex, formId, label) {
        this._stepIndex = stepIndex;
        this._formId = formId;
        this._label = label;

        this._element = document.createElement('li', {is: 'latus-step-button'});

    }

    rendered() {
        if (this._stepIndex === 0) {
            console.log(this._stepIndex);
            this._element.querySelector('.nav-link').classList.add('active');
        }

        this._element.querySelector('.button-label').innerText = this._label;
        this._element.querySelector('.nav-link').setAttribute('data-bs-target', '#' + this._formId);
        this._element.querySelector('.nav-link').setAttribute('data-bs-slide-to', this._stepIndex);
    }

    build() {
        return this._element;
    }
}