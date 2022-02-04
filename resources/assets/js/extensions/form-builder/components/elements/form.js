export class Form extends HTMLFormElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('needs-validation');
        this.setAttribute('novalidate', 'novalidate');
    }
}