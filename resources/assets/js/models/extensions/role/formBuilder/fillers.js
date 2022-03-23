export function fillers(form) {
    let roleCallback = (form, elements) => {
        let roleData = window.latus.exposed('role');

        elements.forEach(function (element) {
            let fieldName = element.getAttribute('data-latus-name');
            let fieldValue = roleData[fieldName];

            if (!fieldValue) {
                return;
            }

            if (element.hasAttribute('data-is-float')) {
                element.value = parseInt(fieldValue) / 1000;
                return;
            }

            element.value = fieldValue;
        });
    };

    form.fill({
        '[data-latus-group="role"]': roleCallback,
    })
    
    return form;
}