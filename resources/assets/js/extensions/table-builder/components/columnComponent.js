export class ColumnComponent {
    _headElement;

    constructor({name, label, clearWidth}) {
        this._headElement = document.createElement('th');
        this._headElement.setAttribute('scope', 'col');
        this._headElement.setAttribute('data-latus-name', name);

        if (clearWidth) {
            this._headElement.style.width = '1px';
        }

        this._headElement.innerText = label;
    }

    getHeadElement() {
        return this._headElement;
    }
}