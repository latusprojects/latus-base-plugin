export function userCan(action) {
    return new AuthorizationService().userCan(action);
}

export class AuthorizationService {
    static #actions = {};

    static fetchActionValues() {
        let exposedActionValues = window.latus.exposed('auth') ?? {};

        if (exposedActionValues !== null) {
            Object.assign(AuthorizationService.#actions, exposedActionValues);
        }
    }

    userCan(action) {
        let authorized = AuthorizationService.#actions?.[action] ?? false;

        if (authorized !== true && authorized !== false) {
            authorized = false;
        }

        return authorized;
    }
}