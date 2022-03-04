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
            let actionsHTML = `<div class="btn-group">`;

            if (item.can_be_viewed) {
                actionsHTML += `
                    <a class="btn btn-link "
                        data-model-id="${item.id}"
                        href="${window.latus.route('users.show', {user: item.id})}">
                            ${window.latus.trans('latus::nav.context.details')}
                    </a>`;
            }

            if (item.can_be_updated) {
                actionsHTML += `
                    <a class="btn btn-link"
                        href="${window.latus.route('users.edit', {user: item.id})}">
                            ${window.latus.trans('latus::nav.context.edit')}
                    </a>
                `;
            }

            if (item.can_be_deleted) {
                actionsHTML += `
                    <div class="btn-group">
                        <a class="btn btn-link dropdown-toggle text-decoration-none" 
                            href="#"
                            data-bs-toggle="dropdown">
                                ${window.latus.trans('latus::nav.context.more')}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item btn btn-link js-lh-show-delete-modal"
                                    href="#"
                                    data-model-id="${item.id}">
                                        ${window.latus.trans('latus::nav.context.delete')}
                                </a>
                            </li>
                        </ul>
                    </div>    
                `;

            }

            actionsHTML += `</div>`;

            return {
                id: `<span class="fw-bold">${item.id}</span>`,
                email: item.email,
                roles: item.roles,
                actions: actionsHTML,
            };
        };
    }
}