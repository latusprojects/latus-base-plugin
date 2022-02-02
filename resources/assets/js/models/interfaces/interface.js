export class Interface {
    createModel() {

    }

    edit() {

    }

    view() {

    }

    index() {

    }

    _listeners = {}

    registerListeners() {
        Object.entries(this._listeners).forEach(([eventOrQuery, listeners]) => {
            if (Array.isArray(listeners)) {
                this.#registerListenersForElement(document, eventOrQuery, listeners);
                return;
            }

            let query = eventOrQuery;

            if (listeners instanceof Object) {
                Object.entries(listeners).forEach(([event, targetListeners]) => {

                    document.addEventListener(event, function (eventObj) {
                        if (eventObj.target.matches(query)) {
                            for (const listener of targetListeners) {
                                new listener().handle(eventObj);
                            }
                        }
                    })

                });

            }
        });
    }

    #registerListenersForElement(element, event, listeners) {
        for (const listener of listeners) {
            element.addEventListener(event, function (event) {

                new listener().handle(event);
            });
        }
    }
}