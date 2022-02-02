export class ResponseHandler {
    handle(response, actionCallback) {
        let data = response.data.data;
        let status = response.statusCode;

        actionCallback(data, status);
    }
}