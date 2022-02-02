export class Toast {
    constructor(message, title = null, icon = null, iconColor = null, closable = false) {
        this.title = title;
        this.message = message;
        this.icon = icon;
        this.iconColor = iconColor;
        this.closable = closable;
    }

    push(timeout = null) {
        if (document.getElementById('toastWrapper')) {
            let node = this.#node();

            if (timeout !== null) {
                node.setAttribute('data-bs-delay', timeout);
            }

            document.getElementById('toastWrapper').firstElementChild.prepend(node);

            let bsToast = new window.bs5.Toast(node);

            bsToast.show()
        }
    }

    #node() {
        let toast = document.createElement('div');

        toast.addEventListener('hidden.bs.toast', function (event) {
            event.target.remove();
        });

        toast.classList.add('toast');

        toast.style.zIndex = '1090';

        toast.style.position = 'relative';

        if (this.title !== null || this.closable) {
            let header = document.createElement('div');
            header.classList.add('toast-header');

            if (this.icon !== null) {
                let icon = document.createElement('i');
                icon.classList.add('bi');
                icon.classList.add('bi-' + this.icon);
                icon.classList.add('pe-2');

                if (this.iconColor !== null) {
                    icon.style.color = this.iconColor;
                }

                header.appendChild(icon);
            }

            if (this.title !== null) {
                let title = document.createElement('strong');
                title.classList.add('me-auto');
                title.innerText = this.title;
                header.appendChild(title);
            }

            if (this.closable) {
                let closeButton = document.createElement('button');
                closeButton.classList.add('btn-close');
                closeButton.setAttribute('data-bs-dismiss', 'toast');
                header.appendChild(closeButton);
            }

            toast.appendChild(header);
        }

        let body = document.createElement('div');
        body.classList.add('toast-body');
        body.innerHTML = this.message;

        toast.appendChild(body);

        return toast;
    }
}