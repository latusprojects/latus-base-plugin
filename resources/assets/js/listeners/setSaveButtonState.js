export class SetSaveButtonState {
    handle(event) {

        switch (event.type) {
            case 'latus.saving-model':
            case 'latus.stored-model':
                this.#setButtonState(false);
                break;
            case 'latus.failed-arguments':
            case 'latus.updated-model':
                this.#setButtonState(true);
                break;
        }

    }

    #setButtonState(active = false) {
        let buttons = document.getElementsByClassName('js-latus-save');

        Array.from(buttons).forEach(button => {
            if (active) {
                button.classList.remove('disabled');
                return;
            }
            button.classList.add('disabled');
        });
    }
}