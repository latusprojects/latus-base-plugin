import {ModelService} from "./modelService";

export class UserService extends ModelService {
    constructor() {
        super();
        Object.assign(this._routes, {
            index: 'users.index',
            store: {
                name: 'users.store',
                params: ['user']
            },
            update: {
                name: 'users.update',
                params: ['user']
            },
            delete: {
                name: 'users.destroy',
                params: ['user']
            },
            json: {
                name: 'users.showJson',
                params: ['user']
            },
            paginate: {
                name: 'users.paginate',
                params: []
            },
            addableRoles: 'users.addableRoles'
        });

        this._model = 'user';
    }
}