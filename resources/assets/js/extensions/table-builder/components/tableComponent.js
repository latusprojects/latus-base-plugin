import {ColumnComponent} from "./columnComponent";

export class TableComponent {
    _element;
    _remoteUrl;
    _columns = {};
    _fillCallback = null;
    _targetId;
    _currentPage = 1;

    constructor(targetId) {
        this._element = document.createElement('table');
        this._element.classList.add('table', 'table-responsive', 'table-bordered', 'shadow-sm', 'caption-top')
        this._targetId = targetId;

        this._registerEventListeners();
    }

    _registerEventListeners() {
        let $this = this;

        this._element.addEventListener('latus::rebuild', function (event) {
            $this.render();
        });
    }

    fills(callback) {
        this._fillCallback = callback;

        return this;
    }

    _renderGrid() {
        this._element.innerHTML = `
            <caption></caption>
            <thead class="table-light">
                <tr>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const [name, column] of Object.entries(this._columns)) {
            this._element.querySelector('thead tr').appendChild(column.getHeadElement());
        }
    }

    _createPagination(currentPage, lastPage) {
        let navElement = document.createElement('nav');
        navElement.classList.add('js-latus-page-nav');

        let ulElement = document.createElement('ul');
        ulElement.classList.add('pagination', 'justify-content-end');

        let prevLiElement = document.createElement('li');
        prevLiElement.classList.add('page-item');

        prevLiElement.innerHTML = `
            <a class="page-link" data-latus-page="previous" href="#">
                <span>&laquo;</span>
            </a>
        `;

        if (Number(this._currentPage) === 1) {
            prevLiElement.classList.add('disabled');
        }

        ulElement.appendChild(prevLiElement);

        for (let i = 1; i <= lastPage; i++) {
            let pageLiElement = document.createElement('li');
            pageLiElement.classList.add('page-item');

            pageLiElement.innerHTML = `
                <a class="page-link" data-latus-page="${i}" href="#">
                    ${i}
                </a>
            `;

            if (i === this._currentPage) {
                pageLiElement.classList.add('active');
            }

            ulElement.appendChild(pageLiElement);
        }

        let nextLiElement = document.createElement('li');
        nextLiElement.classList.add('page-item');

        nextLiElement.innerHTML = `
            <a class="page-link" data-latus-page="next" href="#">
                <span>&raquo;</span>
            </a>
        `;

        if (Number(this._currentPage) === Number(lastPage)) {
            nextLiElement.classList.add('disabled');
        }

        ulElement.appendChild(nextLiElement);

        navElement.appendChild(ulElement);

        return navElement;
    }

    _appendItem(item) {
        let rowElement = document.createElement('tr');

        let i = 0;

        for (const [name, column] of Object.entries(this._columns)) {
            let cellElement;

            if (i === 0) {
                cellElement = document.createElement('th');
                cellElement.setAttribute('scope', 'row')
                i++;
            } else {
                cellElement = document.createElement('td');
            }

            if (column.getCellClasses() !== null) {
                cellElement.classList.add(...column.getCellClasses());
            }

            if (item.hasOwnProperty(name)) {
                cellElement.innerHTML = item[name];
            }

            rowElement.appendChild(cellElement);
        }

        this._element.querySelector('tbody').appendChild(rowElement);
    }

    async render(currentPage = 1) {
        this._currentPage = currentPage;

        this._renderGrid();

        let parentElement = document.getElementById(this._targetId);

        parentElement.innerText = ``;

        if (!this._fillCallback) {
            parentElement.appendChild(this._element);
            return;
        }

        let $this = this;

        await this._fillCallback(this._currentPage).then(function (paginator) {

            for (const [key, item] of Object.entries(paginator.items)) {
                if (paginator.hasOwnProperty('callback')) {
                    $this._appendItem(paginator.callback(item));
                    continue;
                }

                $this._appendItem(item);
            }

            parentElement.appendChild($this._element);

            parentElement.appendChild($this._createPagination(paginator.current_page, paginator.last_page));
        });


    }

    addColumn({name, label, clearWidth = false, cellClasses = null}) {
        this._columns[name] = new ColumnComponent({
            name: name,
            label: label,
            clearWidth: clearWidth,
            cellClasses: cellClasses,
        });

        return this;
    }
}