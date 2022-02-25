import {TableComponent} from "./components/tableComponent";
import {Table} from "./components/elements/table";
import {RowExtender} from "./components/elements/rowExtender";
import {ColumnExtender} from "./components/elements/columnExtender";

export class Builder {

    static components_defined = false;

    constructor() {
        this._defineComponents();
    }

    _defineComponents() {
        if (!Builder.components_defined) {
            window.customElements.define('latus-extendable-table', Table, {extends: 'table'});
            window.customElements.define('latus-row-extender', RowExtender, {extends: 'div'});
            window.customElements.define('latus-column-extender', ColumnExtender, {extends: 'div'});

            Builder.components_defined = true;
        }
    }

    async ready() {
        return await Promise.all([
            customElements.whenDefined('latus-extendable-table'),
            customElements.whenDefined('latus-row-extender'),
            customElements.whenDefined('latus-column-extender'),
        ]);
    }

    table(id) {
        return new TableComponent(id);
    }
}