import {UploadButton} from "./components/uploadButton";
import {Container} from "./components/container";
import {Item} from "./components/item";
import {SingleUploadButton} from "./components/singleUploadButton";

export function initFileManager(id, type, options) {
    customElements.define('latus-upload-button', UploadButton, {extends: 'button'});
    customElements.define('latus-upload-container', Container, {extends: 'div'});
    customElements.define('latus-upload-item', Item, {extends: 'div'});
    customElements.define('latus-single-upload-button', SingleUploadButton, {extends: 'button'});
}