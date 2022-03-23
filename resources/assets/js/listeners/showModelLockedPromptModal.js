export class ShowModelLockedPromptModal {
    handle(event) {
        let lockedModal = document.getElementById('lockedModelModal');

        window.bs5.Modal.getOrCreateInstance(lockedModal).show();
    }
}