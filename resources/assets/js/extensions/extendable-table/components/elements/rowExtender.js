export class RowExtender extends HTMLDivElement {
    constructor() {
        super();

        this.classList.add('position-absolute', 'js-row-extender');

        this.addEventListener('click', function (event) {

        });
    }

    connectedCallback() {
        let addFieldElement = document.createElement('button');
        addFieldElement.classList.add('js-add-field', 'btn', 'btn-success', 'btn-sm');
        addFieldElement.innerHTML = '<i class="bi bi-plus"></i>';

        addFieldElement.addEventListener('click', function (event) {
            event.preventDefault();


            let currentFieldElement = event.target.closest('th');

            let newHeadFieldElement = document.createElement('th');
            newHeadFieldElement.classList.add('position-relative');
            newHeadFieldElement.setAttribute('scope', 'col');

            let headRow = event.target.closest('tr');

            let currentColumnIndex = currentFieldElement.cellIndex;

            let newHeadFieldInput = document.createElement('input');
            newHeadFieldInput.classList.add('form-control');

            let newHeadRowExtender = document.createElement('div', {is: 'latus-row-extender'});

            newHeadFieldElement.prepend(newHeadRowExtender);
            newHeadFieldElement.append(newHeadFieldInput);

            headRow.insertBefore(newHeadFieldElement, currentFieldElement);

            event.target.closest('table').querySelectorAll('tbody tr').forEach(function (rowElement) {
                if (rowElement.hasAttribute('data-latus-pseudo')) {
                    return;
                }
                let fieldElements = rowElement.querySelectorAll('td');

                if (currentColumnIndex === headRow.querySelectorAll('th').length - 2) {

                    let newFieldElement = document.createElement('td');
                    newFieldElement.classList.add('position-relative');

                    let newFieldInput = document.createElement('input');
                    newFieldInput.classList.add('form-control');

                    newFieldElement.append(newFieldInput);

                    rowElement.append(newFieldElement);
                    return;
                }

                fieldElements.forEach(function (fieldElement, i) {
                    if (i + 1 === currentColumnIndex) {
                        let newFieldElement = document.createElement('td');
                        newFieldElement.classList.add('position-relative');

                        let newFieldInput = document.createElement('input');
                        newFieldInput.classList.add('form-control');

                        newFieldElement.append(newFieldInput);

                        rowElement.insertBefore(newFieldElement, fieldElement);

                    }

                });
            });
        });

        this.append(addFieldElement);

        let fieldIsPseudo = this.closest('th').hasAttribute('data-latus-pseudo');

        if (!fieldIsPseudo) {
            let removeFieldElement = document.createElement('button');
            removeFieldElement.classList.add('js-remove-field', 'btn', 'btn-danger', 'btn-sm');
            removeFieldElement.innerHTML = '<i class="bi bi-dash"></i>';

            removeFieldElement.addEventListener('click', function (event) {
                event.preventDefault();
                let currentFieldElement = event.target.closest('th');

                let currentColumnIndex = currentFieldElement.cellIndex;

                event.target.closest('table').querySelectorAll('tbody tr').forEach(function (rowElement) {
                    let i = 0;
                    rowElement.querySelectorAll('td').forEach(function (fieldElement) {
                        if (i + 1 === currentColumnIndex) {
                            fieldElement.remove();
                        }

                        i++;
                    });
                });

                currentFieldElement.remove();
            });

            this.append(removeFieldElement);
        }


    }
}