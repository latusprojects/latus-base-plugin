export class UI {
    _stations = {};
    _route;
    _parameters;

    constructor(route, parameters) {
        this._route = route;
        this._parameters = parameters;
    }

    addStation(name, station) {
        if (!this._stations[name]) {
            this._stations[name] = station;
        }
    }

    station(name) {
        return this._stations[name] ?? null;
    }

    listen(stationName, channelName, event, listener) {
        if (this.station(station) === null) {
            return null;
        }

        let channel = this.station(stationName).channel(channelName) ?? null;

        return channel
            ? channel.listen(event, listener)
            : null;
    }

    getRoute() {
        return this._route;
    }

    getParameters() {
        return this._parameters;
    }
}