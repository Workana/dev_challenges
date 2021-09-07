/**
 * Mocking client-server processing
 */

const issue = {
    "number": 250,
    "users": [
        "agostinaaa",
        "davidddd"
    ],
    "userStatuses": [
        {
            "user": "agostinaaa",
            "status": "Waiting",
            "vote": null
        },
        {
            "user": "davidddd",
            "status": "Waiting",
            "vote": 8
        }
    ],
    "status": "Voting"
}

export default {
    getIssue (cb) {
        setTimeout(() => cb(issue), 100)
    }
}
