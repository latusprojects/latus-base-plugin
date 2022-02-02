import {ResponseHandler} from "../handlers/responseHandler";
import {ResponseErrorHandler} from "../handlers/responseErrorHandler";

export class Controller {
    _modelService;

    async index(callback = null, parameters = null, withRelationships = []) {
        return await this._modelService.index(parameters, withRelationships).then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                callback !== null ? callback(data, status) : false;
            })
            
            return response;
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }

    async update(model, attributes, callback = null) {
        return await this._modelService.update(model, attributes).then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                window.latus.currentModel().update(data);
                document.dispatchEvent(new Event('latus.updated-model'));

                callback !== null ? callback(data, status) : false;
            })
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }

    async store(attributes, callback = null) {
        return await this._modelService.store(attributes).then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                window.latus.currentModel().update(data);
                document.dispatchEvent(new Event('latus.stored-model'));

                callback !== null ? callback(data, status) : false;
            })
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }

    async json(model, withRelationships = [], callback = null) {
        return await this._modelService.json(model, withRelationships).then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                callback !== null ? callback(data, status) : false;
            })
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }

    async delete(model, callback = null) {
        return await this._modelService.delete(model).then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                callback !== null ? callback(data, status) : false;
            })
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }

    async paginate(callback = null, query = {}, parameters = null, withRelationships = []) {
        return await this._modelService.paginate(query, parameters, withRelationships).then(function (response) {
            new ResponseHandler().handle(response, function (data, status) {
                callback !== null ? callback(data, status) : false;
            })
        }).catch(function (error) {
            new ResponseErrorHandler().handle(error);
        });
    }
}