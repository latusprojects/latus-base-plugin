import {Model} from "./model";

export class Page extends Model {
    gatherAttributes() {
        return {
            text: Laraberg.getContent(),
            title: document.getElementById('titleInput').value,
            permalink: document.getElementById('permalinkInput').value,
        };
    }

    mutateData(mutateFor) {

    }
}