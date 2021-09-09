import api from "./api";
import {isError} from "../../helpers/isError";

export default {
    async signUp(username) {
        const body = {username};
        // eslint-disable-next-line no-unused-vars
        let response;
        try {
            response = await api.post('user/signup', body);
        } catch (err) {
            response = err;
        }
        const { status, data } = response;
        if (!isError(status)) {
            return data.payload[0];
        }
    }
}
