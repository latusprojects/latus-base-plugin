import {ModelService} from "./modelService";

export class PageService extends ModelService {
    constructor() {
        super();
        Object.assign(this._routes, {
            index: 'pages.index',
            store: {
                name: 'pages.store',
                params: ['page']
            },
            update: {
                name: 'pages.update',
                params: ['page']
            },
            delete: {
                name: 'pages.destroy',
                params: ['page']
            },
            json: {
                name: 'pages.showJson',
                params: ['page']
            },
            paginate: {
                name: 'pages.paginate',
                params: []
            }
        });

        this._model = 'page';
    }
}