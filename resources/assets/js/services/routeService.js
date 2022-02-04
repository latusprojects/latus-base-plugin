import {replace} from "lodash";

export function route(key, parameters = {}) {
    return new RouteService().route(key, parameters);
}

export class RouteService {
    static #routes = {};

    fetchRoutes() {
        let exposedRoutes = window?.exposed?.routes ?? {};

        if (exposedRoutes !== null) {
            Object.assign(RouteService.#routes, exposedRoutes);
        }
    }

    addRoutes(routes) {
        Object.assign(RouteService.#routes, routes);
    }

    route(key, parameters = {}) {
        if (!RouteService.#routes.hasOwnProperty(key)) {
            return null;
        }

        let route = RouteService.#routes[key];

        if (Object.keys(parameters).length > 0) {
            Object.entries(parameters).forEach(([parameterKey, parameterValue]) => {
                route = replace(route, ':' + parameterKey, String(parameterValue));
                route = replace(route, '%3A' + parameterKey, String(parameterValue));
            })
        }

        return route;
    }
}