import axios from "axios";
import { AxiosResponse, AxiosRequestConfig } from "axios";

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
    activeRequests: number;
    config: AxiosQueueConfig;
    
    constructor(config: AxiosQueueConfig = {
        maxConcurrentRequests: 2,
        pendingTimeout: 30000,
        requestColdownTime: 0
    }) {
        this.activeRequests = 0;
        this.config = {...config};
    }
    

    setConfig(newConfig: AxiosQueueConfig) {
        this.config = {...newConfig};
    }

    request<T = any, R = AxiosResponse<T>, D = any>(reqData: RequestDataType): Promise<R> {
        return new Promise( async (resolve, reject) => {
            let failed: boolean = false;
            let resData: any;
            let timePassed: number = 0;

            while(timePassed < this.config.pendingTimeout && this.activeRequests > this.config.maxConcurrentRequests)
            {
                await sleep(15);
                timePassed+= 10;
            }

            if (this.config.requestColdownTime > 0) {
                await sleep(this.config.requestColdownTime);
            }

            this.activeRequests++;
            if (timePassed >= this.config.pendingTimeout) {
                this.activeRequests--;
                reject("pending queue timeout");
            } else {
                do {
                    try {
                        if (reqData.method == 'post') {
                            resData = (await axios.post(reqData.url, reqData.data, reqData.config));
                        } else {
                            resData = (await axios.get(reqData.url, reqData.config));
                        }
                        failed = false;
                    } catch(e) {
                        resData = e;
                        failed = true;
                    }
                } while (failed && reqData.retriesLeft-- > 0);

                this.activeRequests--;
                failed ? reject(resData) : resolve(resData);
            }
        });
    }

    async post<T = any, R = AxiosResponse<T>, D = any>(url: string, axiosData?: D, axiosConfig?: AxiosRequestConfig<D>, retryTimes: number = 0): Promise<R> {
        return await this.request({method: 'post', url, data: axiosData, config: axiosConfig, retriesLeft: retryTimes} as RequestDataType);
    }

    async get<T = any, R = AxiosResponse<T>, D = any>(url: string, axiosConfig?: AxiosRequestConfig<D>, retryTimes: number = 0): Promise<R> {
        return await this.request({method: 'get', url, config: axiosConfig, retriesLeft: retryTimes} as RequestDataType);
    }
}

export const axiosQueue = new AxiosQueueClass();