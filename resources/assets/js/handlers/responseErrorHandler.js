import {Toast} from '../components/toast';
import {isUndefined} from "lodash/lang";
import {trans} from "../services/translationService";

export class ResponseErrorHandler {
    handle(error, errorMessage = null) {

        let response = error.response;

        if (!errorMessage) {
            errorMessage = 'Request has failed due to an unexpected error.';
        }

        if (isUndefined(response)) {
            this.#handleAfterResponseErrors(error);
            return;
        }

        let status = response.status ?? 404;

        if (status >= 300 && status <= 399) {
            this.#handleClientError(response, errorMessage);
            return;
        }

        if (status === 423) {
            this.#handleLockedResourceError(response);
            return;
        }

        if (status === 422) {
            this.#handleInvalidArgumentsError(response);
            return;
        }

        if (status === 404) {
            this.#handleNotFoundError(response);
            return;
        }

        if (status === 403) {
            this.#handleNotFoundError(response);
            return;
        }

        if (status >= 500 && status <= 599) {
            this.#handleServerError(response, errorMessage);
            return;
        }

        this.#handleServerError(response, errorMessage);
    }

    #handleServerError(response, errorMessage) {
        let toast = new Toast(errorMessage, 'Request Failed', 'exclamation-diamond', 'rgb(220, 53, 69)');

        toast.push(10000);
    }

    #handleClientError(response, errorMessage) {
        let toast = new Toast(errorMessage, 'Request Failed', 'exclamation-diamond', 'rgb(220, 53, 69)');

        toast.push(10000);
    }

    #handleNotFoundError(response) {
        let toast = new Toast('The requested resource does not exist (anymore).', 'Not Found', 'info-circle-fill', 'rgb(220, 53, 69)');

        toast.push(10000);
    }

    #handleInvalidArgumentsError(response) {
        let errors = response.data.errors;

        Object.entries(errors).forEach(([field, messages]) => {
            let validationElements = document.querySelectorAll('[data-latus-validates-for="' + field + '"]');

            let wrapperValidationElements = document.querySelectorAll('[data-latus-validates-using*="--' + field + '"]');

            wrapperValidationElements.forEach(function (element) {
                element.classList.remove('is-valid');
                element.classList.add('is-invalid');
            })

            validationElements.forEach(function (element) {
                element.classList.remove('is-valid');
                element.classList.add('is-invalid');
            });

            let validElements = document.querySelectorAll('[data-latus-validates-for]:not(.is-invalid), [data-latus-validates-using]:not(.is-invalid)');

            validElements.forEach(element => {
                element.classList.add('is-valid');
            })
        })

        document.dispatchEvent(new Event('latus.failed-arguments'));
    }

    #handleLockedResourceError(response) {
        let gatedBy = response.data.data.gated_by;
        let type = gatedBy.type;

        let toastTitle, toastText;


        if (type === 'relations') {
            let relationsHtml = "";

            gatedBy.relations.forEach(relation => {
                relationsHtml += "[<a href='" + relation.search_url + "'>" + relation.label + "</a>] "
            });

            toastTitle = trans('delete.failed.gated.relations.title');
            toastText = trans('delete.failed.gated.relations.text', {relations: relationsHtml});
        }

        let toast = new Toast(toastText, toastTitle, 'info-circle-fill', 'rgb(220, 53, 69)');

        toast.push(10000);

        document.dispatchEvent(new Event('latus.failed-locked'));
    }

    #handleAfterResponseErrors(error) {
        let errorData = {
            type: 'client',
            message: error.message,
            path: window.location.pathname,
            date: Date.now()
        }

        console.log(error);

        let baseEncodedError = btoa(JSON.stringify(errorData));

        let toast = new Toast(
            'The request was successful, but there was an error while executing after-response code.<br/><br/>' +
            'If this issue persists, please contact an administrator and provide them with the code below:<br/><br/>' +
            '<span class="fst-italic small bg-dark text-light">' + baseEncodedError + '</span>' +
            '', 'After-Response Error Encountered', 'info-circle-fill', 'rgb(220, 53, 69)', true);

        toast.push(10000000);
    }
}