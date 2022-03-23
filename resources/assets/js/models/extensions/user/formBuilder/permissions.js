export function permissions(form, mode) {
    form.addStep('permissions', window.latus.trans('latus::user.create.tab.permissions'), ['roles'])
        .addSection('roles', window.latus.trans('latus::user.create.tab.permissions.section.roles'), true, ['roles'])
        .addRow(null, 'Roles')
        .addCustom({
            name: 'rolesInput',
            elementName: 'latus-role-multi-add',
            dataName: 'roles',
            attributes: {
                'data-latus-route': window.latus.route('users.addableRoles')
            }
        });

    return form;
}