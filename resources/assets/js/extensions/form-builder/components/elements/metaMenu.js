export class MetaMenu extends HTMLDivElement {

    constructor() {
        super();
    }

    connectedCallback() {
        this.classList.add('card', 'border-primary')
        this.innerHTML = `
            <div class="card-header">
                Meta-Menu
            </div>
            <div class="card-body p-0">
                <form>
                    <div class="accordion"></div>
                </form>
            </div>
        `;

        this.classList.add('form-section');
    }

}