import axios from 'axios';
import { errorHandler } from './errorHandler';
import authStorage from "../localStorage/authStorage";

class ApiFetch {
    constructor() {
        this.apiUrl = () => process.env.VUE_APP_API_URL;
    }

    get(endpoint, customHeaders = {}) {
        // eslint-disable-next-line no-async-promise-executor
        return new Promise(async (resolve, reject) => {
            const requestData = {
                method: 'get',
                endpoint,
                customHeaders,
            };

            try {
                resolve(await this.makeRequest(requestData));
            } catch (error) {
                reject(error);
            }
        });
    }

    post(endpoint, body, customHeaders = {}) {
        // eslint-disable-next-line no-async-promise-executor
        return new Promise(async (resolve, reject) => {
            const requestData = {
                method: 'post',
                endpoint,
                body,
                customHeaders,
            };

            try {
                resolve(await this.makeRequest(requestData));
            } catch (error) {
                reject(error);
            }
        });
    }

    put(endpoint, body, customHeaders = {}) {
        // eslint-disable-next-line no-async-promise-executor
        return new Promise(async (resolve, reject) => {
            const requestData = {
                method: 'put',
                endpoint,
                body,
                customHeaders,
            };

            try {
                resolve(await this.makeRequest(requestData));
            } catch (error) {
                reject(error);
            }
        });
    }

    delete(endpoint, customHeaders = {}) {
        // eslint-disable-next-line no-async-promise-executor
        return new Promise(async (resolve, reject) => {
            const requestData = {
                method: 'delete',
                endpoint,
                customHeaders,
            };

            try {
                resolve(await this.makeRequest(requestData));
            } catch (error) {
                reject(error);
            }
        });
    }

    makeRequest(requestData) {
        // eslint-disable-next-line no-async-promise-executor
        return new Promise(async (resolve, reject) => {
            const response = await axios({
                method: requestData.method,
                baseURL: this.apiUrl(),
                url: `${requestData.endpoint}`,
                data: requestData.body ? requestData.body : null,
                headers: { ...requestData.customHeaders, Authorization: authStorage.getSession() },
            }).catch(error => {
                errorHandler(error.response);
                reject(error.response);
            });

            resolve(response);
        });
    }
}

export default new ApiFetch();
