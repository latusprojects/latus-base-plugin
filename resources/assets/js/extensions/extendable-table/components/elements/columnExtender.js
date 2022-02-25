export class ColumnExtender extends HTMLDivElement {
    constructor() {
        super();

        this.classList.add('position-absolute', 'js-column-extender');

        this.addEventListener('click', function (event) {

        });
    }

    connectedCallback() {
        let addFieldElement = document.createElement('button');
        addFieldElement.classList.add('js-add-field', 'btn', 'btn-success', 'btn-sm');
        addFieldElement.innerHTML = '<i class="bi bi-plus"></i>';

        addFieldElement.addEventListener('click', function (event) {
            event.preventDefault();
            let currentRowElement = event.target.closest('tr');

            let columnCount = currentRowElement.closest('table').querySelector('thead tr').querySelectorAll('th').length;
            columnCount = columnCount ? columnCount - 2 : 0;

            let newRowElement = document.createElement('tr');

            let newHeadElement = document.createElement('th');
            newHeadElement.setAttribute('scope', 'row');
            newHeadElement.classList.add('position-relative');

            let newHeadFieldInput = document.createElement('input');
            newHeadFieldInput.classList.add('form-control');

            let newHeadColumnExtender = document.createElement('div', {is: 'latus-column-extender'});

            newHeadElement.prepend(newHeadColumnExtender);
            newHeadElement.append(newHeadFieldInput);

            newRowElement.append(newHeadElement);

            for (let i = 0; i < columnCount; i++) {
                let newFieldElement = document.createElement('td');
                let newFieldInputElement = document.createElement('input');
                newFieldInputElement.classList.add('form-control');
                newFieldElement.append(newFieldInputElement);

                newRowElement.append(newFieldElement);

            }

            let tbodyElement = event.target.closest('tbody');

            tbodyElement.insertBefore(newRowElement, currentRowElement);
        });

        this.append(addFieldElement, document.createElement('br'));

        let fieldIsPseudo = this.closest('th').hasAttribute('data-latus-pseudo');

        if (!fieldIsPseudo) {
            let removeFieldElement = document.createElement('button');
            removeFieldElement.classList.add('js-remove-field', 'btn', 'btn-danger', 'btn-sm');
            removeFieldElement.innerHTML = '<i class="bi bi-dash"></i>';

            removeFieldElement.addEventListener('click', function (event) {
                event.preventDefault();
                let currentRowElement = event.target.closest('tr');

                currentRowElement.remove();

            });

            this.append(removeFieldElement);
        }


    }
}