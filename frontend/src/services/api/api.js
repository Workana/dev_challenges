import axios from 'axios';
import { errorHandler } from './errorHandler';

class ApiFetch {
    constructor() {
        this.apiUrl = () => process.env.REACT_APP_API_URL;
    }

    get(endpoint, customHeaders = {}) {
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
        return new Promise(async (resolve, reject) => {
            const response = await axios({
                method: requestData.method,
                baseURL: this.apiUrl(),
                url: `${requestData.endpoint}`,
                data: requestData.body ? requestData.body : null,
                headers: { ...requestData.customHeaders },
            }).catch(error => {
                errorHandler(error.response);
                reject(error.response);
            });

            resolve(response);
        });
    }
}

export default new ApiFetch();
