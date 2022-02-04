export class StepFormWrapper extends HTMLDivElement {

    constructor() {
        super();
    }

    connectedCallback() {

        this.classList.add('carousel', 'slide', 'card', 'step-form-wrapper', 'latus-step-carousel');
        this.setAttribute('data-interval', 'false');

        this.innerHTML = `
            <div class="card-header">
                <ul class="nav nav-pills nav-fill carousel-indicators step-form-nav">
                        
                </ul>
            </div>
            <div class="card-body">
                <div class="carousel-inner step-form-steps">
                            
                </div>
            </div>
        `;
    }
}