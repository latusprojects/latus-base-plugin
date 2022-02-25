import axios from "axios";
import {route} from "./routeService";

export class ModelService {
    _routes = {}

    _model = 'model';

    _parameters(required, provided) {
        required.forEach(requiredParameter => {
            if (!provided.hasOwnProperty(requiredParameter)) {
                return;
            }
        });

        return provided;
    }

    _route(action, parameters) {

        let routeObj = this._routes[action];

        if (typeof routeObj === 'string' || routeObj instanceof String) {
            return route(routeObj);
        }

        if (parameters === null) {
            return route(routeObj.name);
        }

        let routeParameters = {};

        if (routeObj.hasOwnProperty('params')) {
            routeParameters = this._parameters(routeObj.params, parameters);
        }

        return route(routeObj.name, routeParameters);
    }

    _attachModelParameter(model, parameters) {
        if (parameters === null) {
            parameters = {};
        }

        parameters[this._model] = model.attribute('id');

        return parameters;
    }

    async index(parameters = null, withRelationships = []) {
        if (!this._routes.hasOwnProperty('index')) {
            return null;
        }

        let route = this._route('index', parameters);

        let finalParameters = {
            with: withRelationships
        };

        if(parameters !== null){
            Object.assign(finalParameters, parameters)
        }

        return await axios.get(route, {params: finalParameters});
    }

    async store(attributes, parameters = null) {
        if (!this._routes.hasOwnProperty('store')) {
            return null;
        }

        let route = this._route('store', parameters);

        return await axios.post(route, attributes);
    }

    async update(model, attributes, parameters = null) {
        if (!this._routes.hasOwnProperty('update')) {
            return null;
        }

        parameters = this._attachModelParameter(model, parameters);

        let route = this._route('update', parameters);

        return await axios.put(route, attributes);
    }

    async delete(model, parameters = null) {
        if (!this._routes.hasOwnProperty('delete')) {
            return null;
        }

        parameters = this._attachModelParameter(model, parameters);

        let route = this._route('delete', parameters);

        return await axios.delete(route);
    }

    async json(model, withRelationships = [], parameters = null) {
        if (!this._routes.hasOwnProperty('json')) {
            return null;
        }

        parameters = this._attachModelParameter(model, parameters);

        let route = this._route('json', parameters);

        return await axios.get(route, {params: {with: withRelationships}});
    }

    async paginate(query = {}, parameters = null, withRelationships = null) {
        if (!this._routes.hasOwnProperty('paginate')) {
            return null;
        }

        let route = this._route('paginate', parameters);

        let finalParams = {};

        if (query !== null) {
            finalParams.search = JSON.stringify(query);
        }

        if (withRelationships !== null) {
            finalParams.with = withRelationships;
        }

        return await axios.get(route, {params: finalParams});
    }
}