export class Section extends HTMLDivElement {

    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('accordion-item');
        this.innerHTML = `
            <h2 class="accordion-header">
                <button class="accordion-button collapsed section-label" type="button" data-bs-toggle="collapse" data-bs-target="">
                </button>
            </h2>
            <div id="" class="accordion-collapse collapse">
                  <div class="accordion-body"></div>
            </div>
        `;

        this.classList.add('form-section');
    }

}