import {StepComponent} from "./stepComponent";
import {MetaMenuComponent} from "./metaMenuComponent";
import {SaveButtonComponent} from "./saveButtonComponent";

export class StepFormComponent {
    _steps = {};
    _formFillers = {};
    _metaMenu;

    _config = {
        metaMenu: false,
        saveButtons: false,
    }

    _element;

    constructor(id) {
        this._element = document.createElement('div', {is: 'latus-step-form'});
        this._metaMenu = new MetaMenuComponent(this);
        this._element.id = id;
    }

    build() {
        return this._element;
    }

    rendered() {
        let stepContainer = this._element.querySelector('.step-form-steps');

        for (let [name, step] of Object.entries(this._steps)) {

            stepContainer.appendChild(step.build());
            step.rendered();
        }

        if (this.getConfig('metaMenu') === true) {
            this.__renderMetaMenu();
        }

        if (this.getConfig('saveButtons') === true) {
            this.__renderSaveButtons();
        }

        if (this._formFillers) {
            for (let [selector, callback] of Object.entries(this._formFillers)) {
                callback(this, this._element.querySelectorAll(selector));
            }
        }
    }

    __renderSaveButtons() {
        let metaNav = this._element.querySelector('.meta-nav');

        let saveButtonItem = document.createElement('li');

        let topSaveButton = new SaveButtonComponent(this.getId(), 'Save').build();

        saveButtonItem.appendChild(topSaveButton);

        metaNav.appendChild(saveButtonItem);

        this.__enableMetaNav();
    }

    __enableMetaNav() {
        this._element.querySelector('.meta-nav-wrapper').classList.remove('d-none');
    }

    __renderMetaMenu() {
        let metaMenu = this._element.querySelector('.meta-menu-wrapper');
        let metaNavButton = this._element.querySelector('.meta-nav button.meta-menu-button');

        metaNavButton.setAttribute('data-bs-target', '#' + this.getId() + '-meta-menu');

        metaMenu.querySelector('.meta-menu').appendChild(this._metaMenu.build());

        this._metaMenu.rendered();

        metaMenu.setAttribute('id', this.getId() + '-meta-menu')


        this.__enableMetaNav();
        metaMenu.classList.remove('d-none');
    }

    addStep(name, label, validatesUsing = null) {
        this._steps[name] = new StepComponent(this, name, label, validatesUsing);

        return this._steps[name];
    }

    step(name) {
        return this._steps[name];
    }

    fill(formFillers) {
        this._formFillers = formFillers;

        return this;
    }

    getElement() {
        return this._element;
    }

    finish(targetId) {
        let element = this.build();

        let targetElement = document.getElementById(targetId);

        targetElement.appendChild(element);

        this.rendered();

        return element;
    }

    getId() {
        return this._element.id;
    }

    meta() {
        return this._metaMenu;
    }

    getConfig(key = null) {
        if (key && this._config.hasOwnProperty(key)) {
            return this._config[key];
        } else if (key) {
            return null;
        }

        return this._config;
    }

    config({
               metaMenu = false,
               saveButtons = false,
           }) {
        this._config = {metaMenu: metaMenu, saveButtons: saveButtons};
    }

}