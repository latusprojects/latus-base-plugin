export function details(form) {
    form.addStep('details', window.latus.trans('latus::user.create.tab.details'), ['name', 'email', 'password', 'password_confirmation'])
        .addSection('baseData', window.latus.trans('latus::user.create.tab.details.section.baseData'), true, ['name', 'email', 'password', 'password_confirmation'])
        .addRow()
        .addInput({
            name: 'nameInput',
            label: window.latus.trans('latus::user.create.input.name'),
            classes: ['col-12', 'col-md-4'],
            dataGroup: 'user',
            dataName: 'name',
            validatesFor: 'name',
        })
        .addInput({
            name: 'emailInput',
            label: window.latus.trans('latus::user.create.input.email'),
            classes: ['col-12', 'col-md-4'],
            dataGroup: 'user',
            dataName: 'email',
            validatesFor: 'email',
        })
        .section().addRow()
        .addInput({
            name: 'passwordInput',
            label: window.latus.trans('latus::user.create.input.password'),
            type: 'password',
            classes: ['col-12', 'col-md-4'],
            dataGroup: 'user',
            dataName: 'password',
            validatesFor: 'password',
            description: 'Min. 8 Zeichen: Min. eine Zahl, ein Buchstabe, ein Sonderzeichen'
        })
        .addInput({
            name: 'passwordConfirmationInput',
            label: window.latus.trans('latus::user.create.input.password_confirmation'),
            type: 'password',
            classes: ['col-12', 'col-md-4'],
            dataGroup: 'user',
            dataName: 'password_confirmation',
            validatesFor: 'password_confirmation',
        })

    return form;
}