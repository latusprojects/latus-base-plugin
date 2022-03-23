import {TableComponent} from "./components/tableComponent";

export class Builder {

    static components_defined = false;

    constructor() {
        this._defineComponents();
    }

    _defineComponents() {
        if (!Builder.components_defined) {

            Builder.components_defined = true;
        }
    }

    async ready() {
        return await Promise.all([]);
    }

    table(targetId) {
        return new TableComponent(targetId);
    }
}