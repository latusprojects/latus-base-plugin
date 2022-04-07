export class NumberFormatter {
    static format(number, decimals = 0, digits = 20) {
        number = Number(number);

        const formatOptions = {
            maximumFractionDigits: decimals,
            maximumSignificantDigits: digits,
        };

        return new Intl.NumberFormat('de-DE', formatOptions).format(number);
    }
}