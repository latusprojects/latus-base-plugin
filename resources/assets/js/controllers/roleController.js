import {Controller} from "./controller";
import {RoleService} from "../services/roleService";
import {ResponseHandler} from "../handlers/responseHandler";
import {ResponseErrorHandler} from "../handlers/responseErrorHandler";

export class RoleController extends Controller {

    constructor() {
        super();
        this._modelService = new RoleService();
    }

    async addableChildren(callback = null) {
        return await this._modelService.addableChildren().then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                callback !== null ? callback(data, status) : false;
            })

            return response;
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }
}