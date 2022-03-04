export class ColumnComponent {
    _headElement;
    _cellClasses;

    constructor({name, label, clearWidth, cellClasses}) {
        this._headElement = document.createElement('th');
        this._headElement.setAttribute('scope', 'col');
        this._headElement.setAttribute('data-latus-name', name);
        this._cellClasses = cellClasses;

        if (clearWidth) {
            this._headElement.style.width = '1px';
        }

        this._headElement.innerText = label;
    }

    getHeadElement() {
        return this._headElement;
    }

    getCellClasses() {
        return this._cellClasses;
    }
}