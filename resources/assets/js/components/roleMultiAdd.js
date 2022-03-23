import axios from "axios";

export class RoleMultiAdd extends HTMLDivElement {
    _roles = {};
    _addedRoles = {};

    constructor() {
        super();

        this.innerHTML = `
            <input class="visually-hidden js-latus-input" value="">
            <div class="row">
                <div class="col-12 col-md-4"> 
                    <div class="card">
                        <div class="card-body js-latus-badges">
                        </div>
                    </div>
                </div>   
                <div class="col-12 col-md-4"> 
                    <div class="input-group">
                        <select class="form-select js-latus-roles-select">
                            <option value="" selected="selected">Add role...</option>
                        </select>
                        <button class="btn btn-primary js-latus-add-role">Add</button>
                    </div>
                    
                </div>   
            </div>
            
        `;
    }

    _createRoleBadgeElement(name, id, level) {
        let badgeElement = document.createElement('span');

        if (Number(level) <= window.exposed.userLevel) {
            badgeElement.classList.add('badge', 'rounded-pill', 'bg-primary', 'text-white', 'js-latus-role-badge');
            badgeElement.style.cursor = 'pointer';
            badgeElement.innerHTML = name + '<i class="bi bi-x"></i>';

            let $this = this;

            badgeElement.addEventListener('click', function (event) {
                let targetElement = event.currentTarget;
                let roleId = targetElement.getAttribute('data-latus-role-id');

                targetElement.remove();

                $this._toggleState(roleId);
            })
        } else {
            badgeElement.classList.add('badge', 'rounded-pill', 'bg-secondary', 'text-white');
        }

        badgeElement.setAttribute('data-latus-role-id', id);
        badgeElement.classList.add('me-1');

        return badgeElement;
    }

    _isRoleAdded(roleId) {
        return this._getBadgeContainerElement().querySelector('span[data-latus-role-id="' + roleId + '"]') !== null;
    }

    _getRequestUrl() {
        return this.getAttribute('data-latus-route');
    }

    async _requestItems() {
        let $this = this;

        return await axios.get(this._getRequestUrl()).then(function (data) {
            $this._roles = data.data.roles;
            $this._addedRoles = data.data.addedRoles !== null && data.data.addedRoles.length > 0 ? data.data.addedRoles : {};

            $this._renderItems();
        });
    }

    _getSelectedRoleOption() {
        return this._getSelectElement().querySelector('option:checked');
    }

    _getAddRoleBtnElement() {
        return this.querySelector('button.js-latus-add-role');
    }

    _getSelectElement() {
        return this.querySelector('select.js-latus-roles-select');
    }

    _getBadgeContainerElement() {
        return this.querySelector('div.js-latus-badges');
    }

    _getInvisibleInputElement() {
        return this.querySelector('input.js-latus-input');
    }

    _fillRoleSelect() {
        let selectElement = this._getSelectElement();

        for (const [i, role] of Object.entries(this._roles)) {
            let optionElement = document.createElement('option');
            optionElement.setAttribute('value', role.id);
            optionElement.innerText = role.name + ' (' + role.level + ')';
            optionElement.setAttribute('data-latus-role-level', role.level);
            optionElement.setAttribute('data-latus-role-name', role.name);

            selectElement.appendChild(optionElement);
        }
    }

    _toggleState(roleId) {
        let activeIds = [];

        if (this._getInvisibleInputElement().value.length !== 0) {
            activeIds = this._getInvisibleInputElement().value.split(',');
        }

        if (activeIds.includes(roleId)) {
            activeIds.splice(activeIds.indexOf(roleId), 1);
        } else {
            activeIds.push(roleId);
        }

        this._getInvisibleInputElement().value = activeIds.join();
    }

    _createRoleBadges() {
        if (this._addedRoles.length > 0) {
            for (const [i, role] of Object.entries(this._addedRoles)) {
                let badgeElement = this._createRoleBadgeElement(role.name, role.id, role.level);

                this._getBadgeContainerElement().appendChild(badgeElement);

                this._toggleState(role.id);
            }
        }
    }

    _renderItems() {
        this._fillRoleSelect();
        this._createRoleBadges();
    }

    connectedCallback() {
        this._requestItems();

        let $this = this;

        this._getAddRoleBtnElement().addEventListener('click', function (event) {
            event.preventDefault();
            let selectedRole = $this._getSelectedRoleOption();

            if (selectedRole.value && selectedRole.value !== '' && !$this._isRoleAdded(selectedRole.value)) {

                let roleId = selectedRole.value;
                let roleName = selectedRole.getAttribute('data-latus-role-name');
                let roleLevel = selectedRole.getAttribute('data-latus-role-level');

                $this._getBadgeContainerElement().appendChild($this._createRoleBadgeElement(roleName, roleId, roleLevel));

                $this._toggleState(roleId);
            }
        });
    }
}