import 'ContentTools/build/content-tools.min';
import 'ContentEdit/build/content-edit.min';
import axios from 'axios';

window.addEventListener('load', function () {
    let editor = ContentTools.EditorApp.get();
    editor.init('[data-editable]', 'data-name');

    editor.addEventListener('saved', function (ev) {
        let name, payload, regions, xhr;

        regions = ev.detail().regions;
        if (Object.keys(regions).length === 0) {
            return;
        }

        this.busy(true);

        payload = new FormData();

        for (name in regions) {
            if (regions.hasOwnProperty(name)) {
                payload.append(name, regions[name]);
            }
        }

        axios.post()
    });
});