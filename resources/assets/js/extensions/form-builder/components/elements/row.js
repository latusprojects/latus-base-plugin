export class Row extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('row', 'mb-3', 'g-3');
    }
}