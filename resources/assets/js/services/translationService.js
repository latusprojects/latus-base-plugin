import {replace} from "lodash";

export function trans(key, toReplace = {}) {
    return new TranslationService().trans(key, toReplace);
}

export class TranslationService {
    static #translations = {};

    fetchTranslations() {
        let exposedTranslations = window?.exposed?.trans ?? {};

        if (exposedTranslations !== null) {
            this.addTranslations(exposedTranslations);
        }
    }

    addTranslations(translations) {
        Object.assign(TranslationService.#translations, translations);
    }

    trans(key, toReplace = {}) {
        if (!TranslationService.#translations.hasOwnProperty(key)) {
            return key;
        }

        let translation = TranslationService.#translations[key];

        if (Object.keys(toReplace).length > 0) {
            Object.entries(toReplace).forEach(([replaceKey, replaceValue]) => {
                translation = replace(translation, ':' + replaceKey, replaceValue);
            })
        }

        return translation;
    }
}