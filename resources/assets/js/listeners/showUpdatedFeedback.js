import {Toast} from "../components/toast";
import {trans} from "../services/translationService";

export class ShowUpdatedFeedback {
    handle(event) {
        let toast = new Toast(trans('edit.success.text'), trans('edit.success.title', {id: window.latus.currentModel().attribute('id')}), 'check-lg', 'rgb(21, 115, 71)');
        toast.push(10000);
    }
}