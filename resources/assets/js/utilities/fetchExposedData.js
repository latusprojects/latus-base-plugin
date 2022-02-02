import axios from "axios";

export async function fetchExposedData() {
    return axios.get('/assets/exposedData.json').then(response => {
        return response.data;
    })
}