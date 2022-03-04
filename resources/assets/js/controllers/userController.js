import {Controller} from "./controller";
import {UserService} from "../services/userService";

export class UserController extends Controller {

    constructor() {
        super();
        this._modelService = new UserService();
    }
}