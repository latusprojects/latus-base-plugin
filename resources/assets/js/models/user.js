import {Model} from "./model";

export class User extends Model {
    gatherAttributes() {
        let roles = this.#getRolesInputValue().split(',');

        if (roles[0] === '') {
            roles = [];
        }

        return Object.assign(this.#gatherGroup('user'), {roles: roles});
    }

    #getRolesInputValue() {
        return document.querySelector('input.js-latus-input[data-latus-name="roles"]').value;
    }

    #gatherGroup(group) {
        let elements = document.querySelectorAll('[data-latus-group="' + group + '"]');

        let data = {};

        let $this = this;

        elements.forEach(function (element) {
            let key = element.getAttribute('data-latus-name');

            if (element.tagName.toLowerCase() === 'textarea') {
                if (element.value === '') {
                    return;
                }

                data[key] = element.value;

                return;
            }

            if (element.getAttribute('type') === 'checkbox') {
                data[key] = element.checked;
                return;
            }

            data[key] = $this.convertToSafeIntIfFloat(element);
        })

        return data;
    }

    convertToSafeIntIfFloat(element) {
        if (element.hasAttribute('data-is-float')) {
            if (element.value && element.value !== '') {
                return Math.trunc(parseFloat(element.value) * 1000);
            }

            return null;
        }

        return element.value;
    }

    mutateData(mutateFor) {

    }
}