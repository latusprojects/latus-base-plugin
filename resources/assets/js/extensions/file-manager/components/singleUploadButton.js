import {route} from "../../../services/routeService";

export class SingleUploadButton extends HTMLButtonElement {
    _target_container;
    _type;

    constructor() {
        super();

        this.addEventListener('click', function (event) {
            event.target.handleClick();
        });
    }

    connectedCallback() {
        this.classList.add('btn', 'btn-outline-primary');
        this._target_container = this.getAttribute('data-container');
        this._type = this.getAttribute('data-type');
        this.setAttribute('type', 'button');
    }

    handleClick() {
        window.open(route('fileManager') + '?type=' + this._type || 'file', 'FileManager', 'width=900,height=600');

        let containerElement = document.getElementById(this._target_container);
        let type = this._type;

        window.SetUrl = function (items) {

            for (let item of items) {
                let itemElement = document.createElement('div', {is: 'latus-upload-item'});

                itemElement.setAttribute('data-path-thumb', item.thumb_url);
                itemElement.setAttribute('data-path', item.url);

                containerElement.innerHTML = '';
                containerElement.appendChild(itemElement);

                itemElement.querySelector('img').setAttribute('onclick', "window.open('" + item.url + "', 'tab'); return false;")

                return;
            }
        }
    }

}