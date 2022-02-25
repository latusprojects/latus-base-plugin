import {TranslationService} from "./services/translationService";
import {RouteService} from "./services/routeService";
import {ACTION_CREATE, ACTION_EDIT, ACTION_INDEX, ACTION_VIEW} from "./models/crud";
import {PageInterface} from "./models/interfaces/pageInterface";
import {Page} from "./models/page";
import {init} from "./gutenberg/init";
import {PageController} from "./controllers/pageController";
import Latus from "./latus";
import {DualRangeInput} from "./components/dualRangeInput";

window.latus = Latus;

document.addEventListener('DOMContentLoaded', function () {
    window.latus.fetchExposedData();

    defineElements();

    window.latus.boot();
})

if (!window.hasOwnProperty('bs5')) {
    window.bs5 = require('bootstrap/dist/js/bootstrap.min');
}

function defineElements() {

    //window.customElements.define('latus::upload-button', UploadButton, {extends: 'button'});
    window.customElements.define('latus-dual-range-input', DualRangeInput, {extends: 'div'});
}

function registerCrud() {
    window.latus.CRUD.registerCrud('page', {
        model: function (attributes) {
            return new Page(attributes);
        },
        crudInterface: function () {
            return new PageInterface()
        },
        controller: function () {
            return new PageController()
        }
    });
}

document.addEventListener('latus.booted', function () {

    init();

    if (!window.hasOwnProperty('model') && window.hasOwnProperty('action')) {
        return;
    }
    document.dispatchEvent(new Event('latus.registers'));

    registerCrud();

    new TranslationService().fetchTranslations();
    new RouteService().fetchRoutes();

    switch (window.action) {
        case ACTION_CREATE:
            window.latus.CRUD.createModel(window.model);
            break;
        case ACTION_EDIT:
            window.latus.CRUD.edit(window.model);
            break;
        case ACTION_VIEW:
            window.latus.CRUD.view(window.model);
            break;
        case ACTION_INDEX:
            window.latus.CRUD.index(window.model);
            break;
        default:
            window.latus.CRUD.action(window.action, window.model);
            break;
    }
});