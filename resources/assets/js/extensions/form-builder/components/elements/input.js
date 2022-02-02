export class Input extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        let labelElement = document.createElement('label');
        labelElement.setAttribute('for', '');
        labelElement.classList.add('d-none');

        let type = this.getAttribute('data-type');

        let inputElement = document.createElement('input');
        inputElement.setAttribute('id', '');
        inputElement.setAttribute('name', '');
        inputElement.setAttribute('value', '');
        inputElement.setAttribute('type', type);

        let descriptionElement = document.createElement('div');
        descriptionElement.setAttribute('id', '');
        descriptionElement.classList.add('form-text', 'd-none');

        if (type === 'checkbox') {
            let wrapper = document.createElement('div');
            wrapper.classList.add('form-check')
            inputElement.classList.add('form-check-input');
            labelElement.classList.add('form-check-label')
            wrapper.append(inputElement, labelElement, descriptionElement);
            this.append(wrapper);
        } else {
            inputElement.classList.add('form-control');
            labelElement.classList.add('form-label');
            this.append(labelElement, inputElement, descriptionElement);
        }


    }

}