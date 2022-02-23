export class StepFormWrapper extends HTMLDivElement {

    constructor() {
        super();
    }

    connectedCallback() {

        this.classList.add('carousel', 'slide', 'card', 'step-form-wrapper', 'latus-step-carousel');
        this.setAttribute('data-interval', 'false');

        this.innerHTML = `
            <div class="card-header">
                <div class="row">
                    <div class="col-auto meta-nav-wrapper d-none">
                        <ul class="nav nav-pills nav-fill meta-nav">
                            <li><button class="btn meta-menu-button" data-bs-toggle="collapse" data-bs-target=""><i class="bi bi-gear"></i></button></li>
                        </ul>
                    </div>
                    <div class="col-auto flex-fill">
                        <ul class="nav nav-pills nav-fill carousel-indicators step-form-nav">
                        
                        </ul>
                    </div>
                </div>
                
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-8 flex-fill">
                        <div class="carousel-inner step-form-steps">
                                
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 meta-menu-wrapper collapse collapse-horizontal d-none">
                        <div class="meta-menu"></div>
                    </div>
                </div>
                
                
            </div>
        `;
    }
}