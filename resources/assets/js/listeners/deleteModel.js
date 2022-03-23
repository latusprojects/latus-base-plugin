export class DeleteModel {
    handle(event) {
        let model = window.latus.currentModel();

        let controller = window.latus.CRUD.getModelControllerInstance();

        controller.delete(model, function (data, status) {
            window.bs5.Modal.getInstance(document.getElementById('deleteModelModal')).hide();

            document.dispatchEvent(new Event('latus.deleted-model'));
        });
    }


}