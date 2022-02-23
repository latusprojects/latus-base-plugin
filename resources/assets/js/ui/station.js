export class Station {
    _channels = {};

    getUi() {
        return window.latus.ui();
    }

    channels() {
        return this._channels;
    }

    addChannel(name, channel) {
        if (!this._channels.hasOwnProperty(name)) {
            this._channels[name] = channel;
        }
    }

    channel(name) {
        return this._channels[name] ?? null;
    }
}