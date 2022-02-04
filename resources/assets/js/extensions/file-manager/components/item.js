const TYPE_IMAGE = 'image';
const TYPE_FILE = 'file';

export class Item extends HTMLDivElement {
    _file_path;
    _type;

    constructor() {
        super();
        this.innerHTML = `
            <div class="card">
                <div class="card-header text-end">
                    <button class="btn btn-link btn-sm js-delete-self" type="button"><i class="bi bi-trash"></i></button>
                </div>
                <img class="card-img-top d-none" style="cursor: pointer;" src="" alt="">
                <div class="card-body"></div>
                <div class="card-footer small"></div>
            </div>
        `;

        let $this = this;

        this.querySelector('.js-delete-self').addEventListener('click', function (event) {
            $this.remove();
        })
    }

    connectedCallback() {
        this.classList.add('file-item', 'col-12', 'col-sm-4', 'col-md-3', 'col-lg-2');
        this._type = this.getAttribute('data-type');
        this._file_path = this.getAttribute('data-path');

        if (this._type === TYPE_IMAGE) {
            let imgElement = this.querySelector('.card-img-top');
            imgElement.classList.remove('d-none');
            imgElement.setAttribute('src', this._file_path)
        }

        this.querySelector('.card-footer').innerHTML = `<span>${this._file_path}</span>`;
    }
}