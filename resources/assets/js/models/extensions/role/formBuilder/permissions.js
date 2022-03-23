export function permissions(form, mode) {
    form.addStep('permissions', window.latus.trans('latus::role.create.tab.permissions'), ['child_roles'])
        .addSection('roles', window.latus.trans('latus::role.create.tab.permissions.section.roles'), true, ['child_roles'])
        .addRow(null, 'Child-Roles')
        .addCustom({
            name: 'rolesInput',
            elementName: 'latus-role-multi-add',
            dataName: 'roles',
            attributes: {
                'data-latus-route': window.latus.route('roles.addableChildren')
            }
        });

    return form;
}