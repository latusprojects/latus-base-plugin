export class Textarea extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        let labelElement = document.createElement('label');
        labelElement.setAttribute('for', '');
        labelElement.classList.add('d-none');

        let type = this.getAttribute('data-type');

        let textareaElement = document.createElement('textarea');
        textareaElement.setAttribute('id', '');
        textareaElement.setAttribute('name', '');
        textareaElement.setAttribute('value', '');
        textareaElement.setAttribute('type', type);

        let descriptionElement = document.createElement('div');
        descriptionElement.setAttribute('id', '');
        descriptionElement.classList.add('form-text', 'd-none');

        if (type === 'checkbox') {
            let wrapper = document.createElement('div');
            wrapper.classList.add('form-check')
            textareaElement.classList.add('form-check-input');
            labelElement.classList.add('form-check-label')
            wrapper.append(textareaElement, labelElement, descriptionElement);
            this.append(wrapper);
        } else {
            textareaElement.classList.add('form-control');
            labelElement.classList.add('form-label');
            this.append(labelElement, textareaElement, descriptionElement);
        }


    }

}