import api from "./api";

export default {
    async signUp(username) {
        const body = {username};
        // eslint-disable-next-line no-unused-vars
        let response;
        try {
            response = await api.post('user/signup', body);
        } catch (error) {
            response = error;
        }
        return response;
    }
}
