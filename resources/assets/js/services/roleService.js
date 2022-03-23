import {ModelService} from "./modelService";
import axios from "axios";

export class RoleService extends ModelService {
    constructor() {
        super();
        Object.assign(this._routes, {
            index: 'roles.index',
            store: {
                name: 'roles.store',
                params: ['role']
            },
            update: {
                name: 'roles.update',
                params: ['role']
            },
            delete: {
                name: 'roles.destroy',
                params: ['role']
            },
            json: {
                name: 'roles.showJson',
                params: ['role']
            },
            paginate: {
                name: 'roles.paginate',
                params: []
            },
            addableChildren: 'roles.addableChildren'
        });

        this._model = 'role';
    }

    async addableChildren() {
        if (!this._routes.hasOwnProperty('addableChildren')) {
            return null;
        }

        let route = this._route('addableChildren');

        return await axios.get(route);
    }
}