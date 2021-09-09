import api from "./api";
import {isError} from "../../helpers/isError";

/**
 * Mocking client-server processing
 */

// const issue = {
//     "number": 250,
//     "users": [
//         "agostinaaa",
//         "davidddd"
//     ],
//     "userStatuses": [
//         {
//             "user": "agostinaaa",
//             "status": "Waiting",
//             "vote": null
//         },
//         {
//             "user": "davidddd",
//             "status": "Waiting",
//             "vote": 8
//         }
//     ],
//     "status": "Voting"
// }

export default {
    async joinIssue(issue) {
        // eslint-disable-next-line no-unused-vars
        let response;
        try {
            response = await api.post(`issue/${issue}/join`);
        } catch (err) {
            response = err;
        }
        const { status } = response;
        if (!isError(status)) {
            console.log(response);
        }
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
        console.log(body)
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
