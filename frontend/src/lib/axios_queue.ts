import axios from "axios";

interface RequestDataType {
    method: string;
    url: string;
    data?: any;
    config?: any;
    retriesLeft: number;
}
export interface AxiosQueueConfig {
    pendingTimeout: number;
    requestColdownTime: number;
    maxConcurrentRequests: number;
}

function sleep(ms: number) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

export class AxiosQueueClass
{
    #activeRequests: number;
    #config: AxiosQueueConfig;
    
    constructor(config: AxiosQueueConfig = {
        maxConcurrentRequests: 2,
        pendingTimeout: 30000,
        requestColdownTime: 0
    }) {
        this.#activeRequests = 0;
        this.#config = {...config};
    }
    

    config(newConfig: AxiosQueueConfig) {
        this.#config = {...newConfig};
    }

    #request(reqData: RequestDataType) {
        return new Promise( async (resolve, reject) => {
            let failed: boolean = false;
            let resData: any;
            let timePassed: number = 0;

            while(timePassed < this.#config.pendingTimeout && this.#activeRequests > this.#config.maxConcurrentRequests)
            {
                await sleep(15);
                timePassed+= 10;
            }

            if (this.#config.requestColdownTime > 0) {
                await sleep(this.#config.requestColdownTime);
            }

            this.#activeRequests++;
            if (timePassed >= this.#config.pendingTimeout) {
                this.#activeRequests--;
                reject("pending queue timeout");
            } else {
                do {
                    try {
                        if (reqData.method == 'post') {
                            resData = (await axios.post(reqData.url, reqData.data, reqData.config)).data;
                        } else {
                            resData = (await axios.get(reqData.url, reqData.config)).data;
                        }
                        failed = false;
                    } catch(e) {
                        resData = e;
                        failed = true;
                    }
                } while (failed && reqData.retriesLeft-- > 0);

                this.#activeRequests--;
                failed ? reject(resData) : resolve(resData);
            }
        });
    }

    post(url: string, axiosData: any = {}, axiosConfig: any = {}, retryTimes: number = 0) {
        return this.#request({method: 'post', url, data: axiosData, config: axiosConfig, retriesLeft: retryTimes} as RequestDataType);
    }

    get(url: string, axiosConfig: any = {}, retryTimes: number = 0) {
        return this.#request({method: 'get', url, config: axiosConfig, retriesLeft: retryTimes} as RequestDataType);
    }
}

export const axiosQueue = new AxiosQueueClass();