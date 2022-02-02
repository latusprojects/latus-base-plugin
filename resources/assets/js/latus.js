import {CRUD} from "./models/crud";
import {trans} from "./services/translationService";
import {route} from "./services/routeService";
import {Controller} from "./controllers/controller";
import {Model} from "./models/model";
import {Interface} from "./models/interfaces/interface";
import {ModelService} from "./services/modelService";
import {ResponseErrorHandler} from "./handlers/responseErrorHandler";
import {ResponseHandler} from "./handlers/responseHandler";
import {Builder} from "./extensions/form-builder/builder";
import {initFileManager} from "./extensions/file-manager/fileManager";
import {fetchExposedData} from "./utilities/fetchExposedData";

const Latus = {
    _currentModel: null,
    _exposedData: {},

    CRUD: CRUD,

    boot() {
        initFileManager();

        fetchExposedData().then(data => {
            if (!window.hasOwnProperty('exposed')) {
                window.exposed = {};
            }

            Object.assign(window.exposed, data);

            document.dispatchEvent(new Event('latus.booted'));
        })
    },

    currentModel() {
        return this._currentModel;
    },

    setCurrentModel(model) {
        this._currentModel = model;

        return this._currentModel;
    },

    controller(modelName) {
        return CRUD.getModelControllerInstance(modelName);
    },

    exposed(key) {
        return this._exposedData?.[key];
    },

    fetchExposedData() {
        if (window.hasOwnProperty('exposed')) {
            Object.assign(this._exposedData, window.exposed);
        }
    },

    trans(key, toReplace = {}) {
        return trans(key, toReplace);
    },

    route(key, parameters = {}) {
        return route(key, parameters);
    },

    extendable: {
        controller: Controller,
        model: Model,
        modelInterface: Interface,
        service: ModelService
    },

    handlers: {
        responseError: ResponseErrorHandler,
        response: ResponseHandler,
    },

    builders: {
        form: Builder
    }
}

export default Latus;