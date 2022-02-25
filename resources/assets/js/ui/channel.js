export class Channel {
    _listeners = {};
    _stationName;

    constructor(stationName) {
        this._stationName = stationName;
    }

    getStation() {
        return window.latus.ui().station(this._stationName);
    }

    listen(event, listener) {
        if (this._listeners.hasOwnProperty(event)) {
            this._listeners[event] = [];
        }

        this._listeners.push(listener);
    }

    dispatch(event, payload) {
        if (this._listeners.hasOwnProperty(event)) {
            let listeners = this._listeners[event];

            for (const listener of listeners) {
                listener(event, payload);
            }
        }
    }
}