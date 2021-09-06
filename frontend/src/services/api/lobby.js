/**
 * Mocking client-server processing
 */

const issue = {
    "status": "voting",
    "members": [
        {"name": "florencia", "status": "voted"},
        {"name": "kut", "status": "waiting"},
        {"name": "lucho", "status": "passed"}
    ]
}

export default {
    getIssue (cb) {
        setTimeout(() => cb(issue), 100)
    }
}
