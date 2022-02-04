import {Interface} from "./interface";
import {StorePage} from "../../listeners/storePage";
import {SetSaveButtonState} from "../../listeners/setSaveButtonState";
import {ShowStoredFeedback} from "../../listeners/showStoredFeedback";
import {ShowUpdatedFeedback} from "../../listeners/showUpdatedFeedback";

export class PageInterface extends Interface {
    _listeners = {
        '#createPageForm': {
            submit: [StorePage]
        },
        '#editPageForm': {
            submit: [StorePage]
        },
        'latus.saving-model': [SetSaveButtonState],
        'latus.stored-model': [ShowStoredFeedback],
        'latus.updated-model': [ShowUpdatedFeedback, SetSaveButtonState]
    };

    createModel() {
        Laraberg.init('textInput', {sidebar: false, laravelFilemanager: {prefix: '/admin/files'}});

        document.getElementById('loadingIndicator').classList.add('d-none');
    }

    edit() {
        Laraberg.init('textInput', {sidebar: false, laravelFilemanager: {prefix: '/admin/files'}});

        document.getElementById('loadingIndicator').classList.add('d-none');
    }

    index() {
        super.index();
    }
}