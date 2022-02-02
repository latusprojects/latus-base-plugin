export class StorePage {
    handle(event) {
        event.preventDefault();
        document.dispatchEvent(new Event('latus.saving-model'));
    }
}