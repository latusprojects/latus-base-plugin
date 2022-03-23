import {Model} from "./model";

export class Role extends Model {
    gatherAttributes() {
        let childRoles = this.#getRolesInputValue().split(',');

        if (childRoles[0] === '') {
            childRoles = [];
        }

        return Object.assign(this.#gatherGroup('role'), {roles: childRoles});
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
        switch (mutateFor) {
            case 'viewModal':
                return {}
            case 'deleteModal':
                return {
                    id: this.attribute('id'),
                    name: this.attribute('name'),
                }
        }
    }
}