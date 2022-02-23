export {ACTION_CREATE, ACTION_EDIT, ACTION_VIEW, ACTION_INDEX, CRUD};

const ACTION_CREATE = 'create';
const ACTION_EDIT = 'edit';
const ACTION_VIEW = 'view';
const ACTION_INDEX = 'index';

class CRUD {

    static registerCrud(modelName, {controller = null, model = null, crudInterface = null}) {
        CRUD.#controllers[modelName] = controller;
        CRUD.#models[modelName] = model;
        CRUD.#crudInterfaces[modelName] = crudInterface;
    }

    static #controllers = {}

    static #models = {}

    static #crudInterfaces = {}

    static getModelControllerInstance(model = window.model) {
        return CRUD.#controllers.hasOwnProperty(model)
            ? new CRUD.#controllers[model]()
            : null;
    }

    static fillModel(modelName, attributes = {}) {
        let finalAttributes = Object.assign(window.exposed.attributes, attributes);

        return window.latus.setCurrentModel(CRUD.#models[modelName](finalAttributes));
    }

    static #createSaveListeners() {
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('js-latus-save')) {
                event.preventDefault();

                document.dispatchEvent(new Event('latus.saving-model'));
                CRUD._clearValidation();
            }
        });
    }

    static _clearValidation() {
        let validationElements = document.querySelectorAll('[data-latus-validates-for]');
        validationElements.forEach(function (element) {
            element.classList.remove('is-invalid');
        });

    }

    static #maybeCallCrudInterface(action, modelName) {
        if (CRUD.#crudInterfaces.hasOwnProperty(modelName)) {

            let crudInterface = CRUD.#crudInterfaces[modelName]();

            crudInterface.registerListeners();

            crudInterface[action]();
        }

        document.dispatchEvent(new Event('latus.loaded'));
    }

    static createModel(modelName) {
        CRUD.fillModel(modelName);
        CRUD.#maybeCallCrudInterface('createModel', modelName);
        CRUD.#createSaveListeners();
        document.addEventListener('latus.saving-model', function (event) {
            let attributes = window.latus.currentModel().gatherAttributes();

            CRUD.#controllers[modelName]().store(attributes);
        });
    }

    static edit(modelName) {
        CRUD.fillModel(modelName);
        CRUD.#maybeCallCrudInterface('edit', modelName);
        CRUD.#createSaveListeners();
        document.addEventListener('latus.saving-model', function (event) {
            let model = window.latus.currentModel();
            let attributes = model.gatherAttributes();

            CRUD.#controllers[modelName]().update(model, attributes);
        });
    }

    static view(modelName) {
        CRUD.#maybeCallCrudInterface('view', modelName);
    }

    static index(modelName) {
        CRUD.#maybeCallCrudInterface('index', modelName);
    }

    static action(action, modelName) {
        CRUD.#maybeCallCrudInterface(action, modelName);
    }
}