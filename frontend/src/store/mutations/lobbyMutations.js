
export default {
    getIssue (state, issue) {
        const {number, userStatuses, status} = issue;
        state.issue = number;
        state.members = userStatuses;
        state.issueStatus = status;
        if(issue.avg){
            state.avg = issue.avg;
        }
    },
}
