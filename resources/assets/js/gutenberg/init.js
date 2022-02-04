import {Mutator} from "./mutator";

export function init() {
    if (window.hasOwnProperty('lb_editor')) {
        let editorElement = document.getElementById('laraberg__editor');

        if (editorElement === null) {
            setTimeout(init, 100);
        } else {
            new Mutator('laraberg__editor').mutate();
        }
    }
}