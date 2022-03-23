export function details(form) {
    form.addStep('details', window.latus.trans('latus::role.create.tab.details'), ['name', 'level'])
        .addSection('baseData', window.latus.trans('latus::role.create.tab.details.section.baseData'), true, ['name', 'level'])
        .addRow()
        .addInput({
            name: 'nameInput',
            label: window.latus.trans('latus::role.create.input.name'),
            classes: ['col-12', 'col-md-4'],
            dataGroup: 'role',
            dataName: 'name',
            validatesFor: 'name',
        })
        .addInput({
            name: 'levelInput',
            label: window.latus.trans('latus::role.create.input.level'),
            classes: ['col-12', 'col-md-4'],
            dataGroup: 'role',
            dataName: 'level',
            validatesFor: 'level',
            badge: {
                pos: 'right',
                label: 'max. ' + (Number(window.exposed.userLevel) - 1)
            }
        })

    return form;
}