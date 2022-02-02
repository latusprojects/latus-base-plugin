import {Controller} from "./controller";
import {PageService} from "../services/pageService";

export class PageController extends Controller {

    constructor() {
        super();
        this._modelService = new PageService();
    }
}