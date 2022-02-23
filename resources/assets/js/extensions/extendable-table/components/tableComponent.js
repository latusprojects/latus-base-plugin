export class TableComponent {
    _formFillers = {};

    _config = {
        extendableRows: false,
        extendableColumns: false,
    }

    _element;

    constructor(id) {
        this._element = document.createElement('div', {is: 'latus-extendable-table'});
        this._element.id = id;
    }

    build() {
        return this._element;
    }

    rendered() {

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

        element.setAttribute('data-latus-extendable-rows', this.getConfig('extendableRows'));
        element.setAttribute('data-latus-extendable-columns', this.getConfig('extendableColumns'));

        let targetElement = document.getElementById(targetId);

        targetElement.appendChild(element);

        this.rendered();

        return element;
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
               extendableRows = false,
               extendableColumns = false,
           }) {
        this._config = {extendableRows: extendableRows, extendableColumns: extendableColumns};
    }

}