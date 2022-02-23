export class Section extends HTMLDivElement {

    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('accordion-item');
        this.innerHTML = `
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="">
                    <span class="section-label"></span>
                    <i class="bi bi-check-circle icon-valid text-success"></i>
                    <i class="bi bi-exclamation-circle icon-invalid text-danger"></i>
                </button>
            </h2>
            <div id="" class="accordion-collapse collapse">
                  <div class="accordion-body"></div>
            </div>
        `;

        this.classList.add('form-section');
    }

}