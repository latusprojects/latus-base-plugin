export class Step extends HTMLDivElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('carousel-item', 'form-step');

        this.innerHTML = `
            <form class="needs-validation" novalidate="">
                <div class="accordion"></div>
            </form>
        `;
    }
}