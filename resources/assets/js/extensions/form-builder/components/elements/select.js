export class Select extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.innerHTML = `
            <label class="form-label d-none" for=""></label>
            <select id="" name="" class="form-select"></select>
            <div id="" class="form-text"></div>
        `;
    }

}