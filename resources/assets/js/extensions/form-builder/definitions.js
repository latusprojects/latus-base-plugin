import {Form} from "./components/elements/form";

let components = {
    'lh-fb-form': [Form, {extends: 'form'}],
}

export function defineComponents() {
    for (let [componentName, component] of Object.entries(components)) {

        if (!window.customElements.get(componentName)) {
            if (Array.isArray(component)) {
                window.customElements.define(componentName, component[0], component[1]);
                continue;
            }

            if (component instanceof HTMLElement) {
                window.customElements.define(componentName, component);
            }
        }
    }
}