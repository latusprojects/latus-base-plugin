export class Container extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('file-container');
    }
}