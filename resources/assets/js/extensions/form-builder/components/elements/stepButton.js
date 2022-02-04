export class StepButton extends HTMLLIElement {
    connectedCallback() {
        this.classList.add('nav-item');

        this.innerHTML = `
            <a class="nav-link has-icon has-icon-right" data-bs-target="" data-bs-slide-to="" href="#">
                <span class="button-label"></span>
                <i class="bi bi-circle icon-waiting icon-right text-dark"></i>
                <i class="bi bi-check-circle icon-valid icon-right text-success d-none"></i>
                <i class="bi bi-exclamation-circle icon-invalid icon-right text-danger d-none"></i>
            </a>`;
    }
}