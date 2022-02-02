export let RendersContent = {
    _props: {},

    with({props = {}}) {
        this._props = props;

        return this;
    },

    addProp(key, value) {
        this._props[key] = value;

        return this;
    },

    before({props}) {

    },

    render({props}) {
        console.log('Component does not render content.');

        return null;
    },

    renders({props}) {

    },

    connectedCallback() {
        if (!this.isConnected) {

            this.before(this._props);

            let content = this.render(this._props);

            if (content) {
                this.innerHTML = this.render(this._props);
            }

            this.renders(this._props);
        }
    }
}