export class DualRangeInput extends HTMLDivElement {

    constructor() {
        super();

        this.classList.add('position-relative', 'latus-dual-range-input');

        this._setupInputs();
    }

    _setupInputs() {
        this._setupListeners();

        this._setupStyling();

        this._showInputs();
    }

    connectedCallback() {
        this._resetValues();
    }

    _resetValues() {
        this._firstInput().value = this._firstInput().getAttribute('min');
        this._secondInput().value = this._secondInput().getAttribute('max');
    }

    _showInputs() {
        this._firstInput().classList.remove('d-none');
        this._secondInput().classList.remove('d-none');
    }

    _setupStyling() {
        this._firstInput().classList.add('position-absolute', 'top-0');

        this._secondInput().classList.add('position-absolute', 'top-0');
    }

    _setupListeners() {
        let $this = this;

        let secondInput = this._secondInput();
        let firstInput = this._firstInput();

        firstInput.addEventListener('input', function (event) {
            let minValue = Number(firstInput.value);
            let maxValue = Number(secondInput.value);

            if (minValue >= maxValue) {
                firstInput.value = maxValue - 1;
            }

            $this._getMinPricePropDisplay().innerText = firstInput.value;
        });

        secondInput.addEventListener('input', function (event) {
            let maxValue = Number(secondInput.value);
            let minValue = Number(firstInput.value);

            if (maxValue <= minValue) {
                secondInput.value = minValue + 1;
            }

            $this._getMaxPricePropDisplay().innerText = secondInput.value;
        });

    }

    _getMinPricePropDisplay() {
        return this.querySelector('[data-latus-prop="min-price"]');
    }

    _getMaxPricePropDisplay() {
        return this.querySelector('[data-latus-prop="max-price"]');
    }

    _firstInput() {
        return this.querySelectorAll('input[type="range"]').item(0) ?? null;
    }

    _secondInput() {
        return this.querySelectorAll('input[type="range"]').item(1) ?? null;
    }
}