export class Table extends HTMLTableElement {
    constructor() {
        super();

        this.classList.add('latus-extendable-table', 'table', 'table-responsive', 'table-bordered');
    }

    _addRowExtenders() {
        if (this.getAttribute('data-latus-extendable-rows')) {
            let headRow = this.querySelector('thead tr');

            let headElements = this.querySelectorAll('thead tr th');

            let elementCount = headElements.length;
            elementCount = elementCount ? elementCount - 1 : 0;

            let i = 0;

            headElements.forEach(function (element) {
                if (!element.hasAttribute('data-latus-pseudo')) {
                    element.classList.add('position-relative');

                    let fieldInput = document.createElement('input');
                    fieldInput.classList.add('form-control');
                    fieldInput.value = element.textContent;

                    element.innerHTML = '';
                    element.appendChild(fieldInput);

                    let rowExtender = document.createElement('div', {is: 'latus-row-extender'});

                    element.prepend(rowExtender);

                    i++;

                    if (i === elementCount) {
                        let pseudoFieldElement = document.createElement('th');
                        pseudoFieldElement.classList.add('border-0', 'position-relative');
                        pseudoFieldElement.setAttribute('data-latus-pseudo', 'true');

                        let pseudoRowExtender = document.createElement('div', {is: 'latus-row-extender'});

                        pseudoFieldElement.appendChild(pseudoRowExtender);

                        headRow.append(pseudoFieldElement);
                    }
                }

            });
        }
    }

    _addColumnExtenders() {
        if (this.getAttribute('data-latus-extendable-columns')) {
            let headElements = this.querySelectorAll('tbody tr th[scope="row"]');

            let elementCount = headElements.length;

            let i = 0;

            headElements.forEach(function (element) {
                if (!element.hasAttribute('data-latus-pseudo')) {
                    element.classList.add('position-relative');

                    let fieldInput = document.createElement('input');
                    fieldInput.classList.add('form-control');
                    fieldInput.value = element.textContent;

                    element.innerHTML = '';
                    element.appendChild(fieldInput);

                    let columnExtender = document.createElement('div', {is: 'latus-column-extender'});

                    element.prepend(columnExtender);

                    i++;

                    if (i === elementCount) {

                        let pseudoRowElement = document.createElement('tr');
                        pseudoRowElement.setAttribute('data-latus-pseudo', true);

                        let pseudoFieldElement = document.createElement('th');
                        pseudoFieldElement.classList.add('border-0', 'position-relative');
                        pseudoFieldElement.setAttribute('scope', 'row');
                        pseudoFieldElement.setAttribute('data-latus-pseudo', 'true');

                        let pseudoColumnExtender = document.createElement('div', {is: 'latus-column-extender'});

                        pseudoFieldElement.appendChild(pseudoColumnExtender);

                        pseudoRowElement.append(pseudoFieldElement);

                        element.closest('tbody').append(pseudoRowElement);
                    }
                }

            });
        }
    }

    connectedCallback() {
        this._addRowExtenders();

        this._addColumnExtenders();
    }
}