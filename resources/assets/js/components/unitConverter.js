export class UnitConverter extends HTMLInputElement {
    formulars = {
        hp: {
            kw: hp => hp / 1.341,
        },
        kw: {
            hp: kw => kw * 1.341,
        }
    };

    constructor() {
        super();
    }

    _getBaseUnit() {
        return this.getAttribute('data-latus-unit');
    }

    _getTargetElement() {
        return document.getElementById(this.getAttribute('data-latus-target'));
    }

    _getTargetUnit() {
        return this._getTargetElement().getAttribute('data-latus-unit');
    }

    _calculate(baseUnit, targetUnit) {
        if (this.value && !isNaN(Number(this.value))) {
            if (!this.formulars.hasOwnProperty(baseUnit) || !this.formulars[baseUnit].hasOwnProperty(targetUnit)) {
                console.error('Could not convert from unit "' + baseUnit + '" to "' + targetUnit + '". Unit not defined.');
                return null;
            }

            let formatOptions = {
                maximumFractionDigits: 4,
                maximumSignificantDigits: 10,
            };

            return new Intl.NumberFormat('de-DE', formatOptions).format(this.formulars[baseUnit][targetUnit](this.value).toFixed(4));
        }

        return 0;
    }

    _setTargetUnitValue() {
        let calculatedValue = this._calculate(this._getBaseUnit(), this._getTargetUnit());

        if (calculatedValue !== null) {
            if (this._getTargetElement().tagName === 'INPUT') {
                this._getTargetElement().value = calculatedValue;
            } else {
                this._getTargetElement().innerText = calculatedValue.toString();
            }
        }
    }

    connectedCallback() {
        this.addEventListener('change', this._setTargetUnitValue);
        if (this.value) {
            this._setTargetUnitValue();
        }
    }
}