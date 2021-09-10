import api from "./api";

export default {
    async joinIssue(issue) {
        // eslint-disable-next-line no-unused-vars
        let response;
        try {
            response = await api.post(`issue/${issue}/join`);
        } catch (err) {
            response = err;
        }
        return response;
    },

    async getIssue(issue) {
        // eslint-disable-next-line no-unused-vars
        let response;
        try {
            response = await api.get(`issue/${issue}`);
        } catch (err) {
            response = err;
        }
        return response;
    },

    async vote(issue, vote) {
        const body = {vote};
        // eslint-disable-next-line no-unused-vars
        let response;
        try {
            response = await api.post(`issue/${issue}/vote`, body);
        } catch (err) {
            response = err;
        }
        return response;
    },
}
