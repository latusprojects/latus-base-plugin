import {Interface} from "./interface";
import {buildForm} from "../extensions/role/formBuilder/formBuilder";
import {SetSaveButtonState} from "../../listeners/setSaveButtonState";
import {ShowStoredFeedback} from "../../listeners/showStoredFeedback";
import {ShowUpdatedFeedback} from "../../listeners/showUpdatedFeedback";
import {ShowModelDeletePromptModal} from "../../listeners/showModelDeletePromptModal";
import {DeleteModel} from "../../listeners/deleteModel";
import {ShowModelLockedPromptModal} from "../../listeners/showModelLockedPromptModal";

export class RoleInterface extends Interface {
    _listeners = {
        '.js-latus-show-delete-modal': {
            'click': [ShowModelDeletePromptModal]
        },
        '.js-latus-confirm-delete': {
            'click': [DeleteModel]
        },
        'latus.saving-model': [],
        'latus.stored-model': [ShowStoredFeedback, SetSaveButtonState],
        'latus.updated-model': [ShowUpdatedFeedback, SetSaveButtonState],
        'latus.failed-arguments': [SetSaveButtonState],
        'latus.model-locked': [ShowModelLockedPromptModal],
    };

    createModel() {
        buildForm().then(function () {
            document.getElementById('loadingIndicator').classList.add('d-none');
        });
    }

    edit() {
        this.#initEditModals();
        buildForm('edit').then(function () {
            document.getElementById('loadingIndicator').classList.add('d-none');

            document.dispatchEvent(new Event('latus.role-form.finished'));
        });
    }

    index() {
        this.#initIndexModals();
        window.latus.fillers['renders::tableWrapper'] = function (item) {
            let actionsHTML = `<div class="btn-group">`;

            if (item.can_be_viewed) {
                actionsHTML += `
                    <a class="btn btn-link "
                        data-model-id="${item.id}"
                        href="${window.latus.route('roles.show', {role: item.id})}">
                            ${window.latus.trans('latus::nav.context.details')}
                    </a>`;
            }

            if (item.can_be_updated) {
                actionsHTML += `
                    <a class="btn btn-link"
                        href="${window.latus.route('roles.edit', {role: item.id})}">
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
                                <a class="dropdown-item btn btn-link js-latus-show-delete-modal"
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
                name: item.name,
                child_roles: item.child_roles,
                actions: actionsHTML,
            };
        };
    }

    #initEditModals() {
        let lockedModal = document.getElementById('lockedModelModal');

        document.body.appendChild(lockedModal);
        new window.bs5.Modal(lockedModal);
    }

    #initIndexModals() {
        let deleteModal = document.getElementById('deleteModelModal');

        document.body.appendChild(deleteModal);
        new window.bs5.Modal(deleteModal);
    }
}