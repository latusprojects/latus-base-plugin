export class Mutator {
    #editorElement;
    #editorId;

    constructor(editorId) {
        this.#editorId = editorId;
        this.#editorElement = document.getElementById(editorId);
    }

    mutate() {
        this.#addSaveButton();
    }

    #addSaveButton() {
        let headerElement = this.#editorElement.querySelector('.edit-post-header');

        let buttonWrapper = document.createElement('div');
        buttonWrapper.classList.add('d-inline-flex', 'pe-3');
        buttonWrapper.innerHTML = '<input type="submit" class="btn btn-primary js-latus-save" value="Save">'

        headerElement.appendChild(buttonWrapper);
    }
}