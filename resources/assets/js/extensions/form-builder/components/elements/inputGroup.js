export class InputGroup extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        let labelElement = document.createElement('label');
        labelElement.setAttribute('for', '');
        labelElement.classList.add('d-none');

        let type = this.getAttribute('data-type');

        let groupElement = document.createElement('div');

        groupElement.classList.add('input-group');

        let inputElement = document.createElement('input');
        inputElement.setAttribute('id', '');
        inputElement.setAttribute('name', '');
        inputElement.setAttribute('value', '');
        inputElement.setAttribute('type', type);

        let descriptionElement = document.createElement('div');
        descriptionElement.setAttribute('id', '');
        descriptionElement.classList.add('form-text', 'd-none');
        
        inputElement.classList.add('form-control');
        labelElement.classList.add('form-label');

        groupElement.appendChild(inputElement);

        this.append(labelElement, groupElement, descriptionElement);
    }

}