import {TranslationService} from "./services/translationService";
import {RouteService} from "./services/routeService";
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

document.addEventListener('latus.booted', function () {

    document.dispatchEvent(new Event('latus.registers'));

    new TranslationService().fetchTranslations();
    new RouteService().fetchRoutes();

});