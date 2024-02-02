import axios from "axios";

export interface RequestDataType {
    request: any;
    thenCallback: Function;
    errorCallback: Function;
    finallyCallback: Function;
    retriesLeft: number;
}

export class RequestQueue
{
    maxConcurrentRequests: number;
    pendingRequests: Array<RequestDataType>;
    activeRequests: number;

    constructor(maxConcurrentRequests: number, retryTimes: number = 0) {
        this.maxConcurrentRequests = maxConcurrentRequests;
        this.pendingRequests = [];
        this.activeRequests = 0;
    }

    addRequest(request: any, thenCallback: Function = () => {}, errorCallback: Function = () => {}, finallyCallback: Function = () => {}, retryTimes: number = 0) {
        let reqData: RequestDataType = {request, thenCallback, errorCallback, finallyCallback, retriesLeft: retryTimes};
        if (this.activeRequests < this.maxConcurrentRequests) {
            this.sendRequest(reqData);
        } else {
            this.pendingRequests.push(reqData);
        }
    }

    sendRequest(reqData: RequestDataType) {
        this.activeRequests++;
        axios(reqData.request)
            .then(r => {
                reqData.thenCallback(r.data);
            })
            .catch(error => {
                if (reqData.retriesLeft > 0) {
                    this.addRequest(reqData.request, reqData.thenCallback, reqData.errorCallback, reqData.finallyCallback, reqData.retriesLeft-1);
                } else {
                    reqData.errorCallback(error);
                }
            })
            .finally(() => {
                this.activeRequests--;
                if (this.pendingRequests.length > 0) {
                    const nextRequest: any = this.pendingRequests.shift();
                    this.sendRequest(nextRequest);
                }
                reqData.finallyCallback();
            })
    }
}