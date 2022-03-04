import {Interface} from "./interface";

export class UserInterface extends Interface {
    _listeners = {};

    createModel() {

        document.getElementById('loadingIndicator').classList.add('d-none');
    }

    edit() {

        document.getElementById('loadingIndicator').classList.add('d-none');
    }

    index() {
        window.latus.fillers['renders::tableWrapper'] = function (item) {
            return {
                id: `<span class="fw-bold">${item.id}</span>`,
                email: item.email,
                actions: 'Actions'
            };
        };
    }
}