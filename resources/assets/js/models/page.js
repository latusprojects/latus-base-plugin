import {Model} from "./model";

export class Page extends Model {
    gatherAttributes() {
        return {
            text: document.getElementById('textInput').value
        };
    }

    mutateData(mutateFor) {

    }
}