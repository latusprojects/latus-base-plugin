import {Toast} from "../components/toast";
import {trans} from "../services/translationService";

export class ShowStoredFeedback {
    handle(event) {
        let toast = new Toast(trans('create.success.text'), trans('create.success.title', {id: window.latus.currentModel().attribute('id')}), 'check-lg', 'rgb(21, 115, 71)');
        toast.push(10000);
    }
}