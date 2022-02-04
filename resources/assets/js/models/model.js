export class Model {
    constructor(attributes) {
        Object.assign(this._attributes, attributes);
    }

    _attributes = {
        id: null,
    };

    attribute(name) {
        if (!this._attributes.hasOwnProperty(name)) {
            return null;
        }

        return this._attributes[name];
    }

    update(attributes) {
        Object.assign(this._attributes, attributes);
    }

    gatherAttributes() {
        console.warn('No attributes gathered for model "' + this.constructor.name + '"');
        return null;
    }

    mutateData(mutateFor) {
        return {};
    }
}