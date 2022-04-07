import {CRUD} from "./models/crud";
import {trans} from "./services/translationService";
import {route} from "./services/routeService";
import {Controller} from "./controllers/controller";
import {Model} from "./models/model";
import {Interface} from "./models/interfaces/interface";
import {ModelService} from "./services/modelService";
import {ResponseErrorHandler} from "./handlers/responseErrorHandler";
import {ResponseHandler} from "./handlers/responseHandler";
import {Builder as FormBuilder} from "./extensions/form-builder/builder";
import {initFileManager} from "./extensions/file-manager/fileManager";
import {fetchExposedData} from "./utilities/fetchExposedData";
import {UI} from "./ui/ui";
import {Builder as TableBuilder} from "./extensions/extendable-table/builder";
import {Builder as DataTableBuilder} from "./extensions/table-builder/builder";
import {AuthorizationService, userCan} from "./services/authorizationService";
import {NumberFormatter} from "./extensions/numbers/NumberFormatter";

const Latus = {
    _currentModel: null,
    _exposedData: {},
    _ui: null,

    CRUD: CRUD,

    ui() {

    },

    boot() {
        this._ui = new UI();

        initFileManager();

        new TableBuilder()
        new FormBuilder();

        fetchExposedData().then(data => {
            if (!window.hasOwnProperty('exposed')) {
                window.exposed = {};
            }

            for (const [key, value] of Object.entries(data)) {
                if (window.exposed.hasOwnProperty(key)) {
                    Object.assign(window.exposed[key], value);
                    continue;
                }

                window.exposed[key] = value;
            }

            if (!window.exposed.hasOwnProperty('routes')) {
                window.exposed.routes = {};
            }

            let baseRoutes = {
                'ui.widgets': '/ui/widgets/:widget',
                'ui.widgets.endpoint': '/ui/widgets/:widget/:endpoint',
                'fileManager': '/admin/files'
            }

            Object.assign(window.exposed.routes, baseRoutes);

            document.dispatchEvent(new Event('latus.booted'));
        });

        AuthorizationService.fetchActionValues();
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

    userCan(action) {
        return userCan(action);
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
        form: FormBuilder,
        table: TableBuilder,
        dataTable: DataTableBuilder,
    },

    format: {
        number: (number, decimals = 0, digits = 20) => NumberFormatter.format(number, decimals, digits),
    },

    fillers: {}
}

export default Latus;