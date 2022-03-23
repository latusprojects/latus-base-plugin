export class ShowModelDeletePromptModal {
    handle(event) {
        let modelId = event.target.getAttribute('data-model-id');
        let model = window.latus.CRUD.fillModel(window.model, {id: modelId});
        let deleteModal = document.getElementById('deleteModelModal');

        this.patchModalDetails(model, deleteModal, ['id']);

        window.bs5.Modal.getOrCreateInstance(deleteModal).show();
    }

    patchModalDetails(model, deleteModal, patchableProperties) {
        let mutatedData = window.latus.currentModel().mutateData('deleteModal');

        patchableProperties.forEach(function (property) {
            let elements = deleteModal.querySelectorAll("[data-latus-prop='" + property + "']");
            elements.forEach(function (element) {
                element.textContent = mutatedData[property];
            });
        });
    }
}