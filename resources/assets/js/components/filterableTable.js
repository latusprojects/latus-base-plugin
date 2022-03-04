import axios from "axios";

export class FilterableTable extends HTMLDivElement {
    _columns = {};

    constructor() {
        super();
    }

    _getTargetId() {
        return this.getAttribute('data-latus-target-id');
    }

    _rebuildTable() {
        let table = new window.latus.builders.dataTable().table(this._getTargetId());

        let columns = this._getColumns();

        for (const [name, column] of Object.entries(columns)) {

            table.addColumn({
                name: name,
                label: column.label,
                clearWidth: column.clearWidth
            });
        }

        let $this = this;

        table.fills(function (page) {
            let filters = $this._getFilters();
            let url = new URL($this._getUrl());

            url.searchParams.set('page', page);

            for (const [filter, value] of Object.entries(filters)) {
                url.searchParams.set(filter, value);
            }

            return axios.get(url.toString()).then(function (response) {
                let data = response.data;

                if (window.latus.fillers['renders::' + $this._getTargetId()]) {
                    data.callback = window.latus.fillers['renders::' + $this._getTargetId()];
                }

                return data;
            });
        });

        table.render();

    }

    _getUrl() {
        return this.getAttribute('data-latus-route');
    }

    _getColumns() {
        let columns = {};

        let columnElements = this.querySelectorAll('.js-latus-columns data');


        columnElements.forEach(function (element) {
            columns[element.value] = {
                label: element.innerHTML,
                clearWidth: element.getAttribute('data-latus-clearwidth') ?? false,
            }
        });

        return columns;
    }

    _getFilters() {
        let filters = {};

        let filterInputs = this.querySelectorAll('[data-latus-filter]');

        filterInputs.forEach(function (element) {
            let filterName = element.getAttribute('data-latus-filter');

            filters[filterName] = element.value;
        });

        return filters;
    }

    _registerEventListeners() {
        let filterInputs = this.querySelectorAll('[data-latus-filter]');

        let targetId = this._getTargetId();

        filterInputs.forEach(function (element) {
            element.addEventListener('change', function (event) {
                let tableElement = document.getElementById(targetId).querySelector('table');
                tableElement.dispatchEvent(new Event('latus::rebuild'));
            });
        });
    }

    connectedCallback() {
        let $this = this;

        document.addEventListener('latus.booted', function () {
            $this._rebuildTable();

            $this._registerEventListeners();
        });
    }

}