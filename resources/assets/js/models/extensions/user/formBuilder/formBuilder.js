import {details} from "./details";
import {permissions} from "./permissions";
import {fillers} from "./fillers";

export async function buildForm(mode = 'create') {
    let builder = new window.latus.builders.form;

    builder.ready().then(function () {
        let form = builder.stepForm('userMasterForm');

        form.config({
            saveButtons: true,
        });

        form = details(form);

        if (mode === 'create') {
            if (window.latus.userCan('user.permission.add')) {
                form = permissions(form, mode);
            }
        }

        if (mode === 'edit') {
            if (window.latus.userCan('user.permission.update')) {
                form = permissions(form, mode);
            }

            form = fillers(form);
        }

        form.finish('userMasterFormContainer');
    });
}