import router from "../../router/router";
import lobby from "../../services/api/lobby";
import {isError} from "../../helpers/isError";

const state = () => ({
    members: [],
    issue: null,
    issueStatus: '',
    avg: null,
})

// getters
const getters = {}

// actions
const actions = {
    joinIssue: async ({ commit }, issue) => {
        const response = await lobby.joinIssue(issue)
        const { status } = response;
        if (!isError(status)) {
            commit('joinIssueSuccessful')
            await router.push(`/lobby/${issue}`)
        }
    },
    getIssue: async ({ commit }, issue) => {
        const response = await lobby.getIssue(issue);
        const { status, data } = response;
        if (!isError(status)) {
            commit('updateIssueSuccessful', data.payload)
        }
    },
    updateIssue:({ commit }, data) => {
        commit('updateIssueSuccessful', data)
    },
    vote: async ({ commit }, payload) => {
        const {issue, vote} = payload;
        const response = await lobby.vote(issue, vote);
        const { status } = response;
        if (!isError(status)) {
            commit('voteSuccesful')
        }
    }
}

// mutations
const mutations = {
    updateIssueSuccessful (state, issue) {
        const {number, userStatuses, status} = issue;
        state.issue = number;
        state.members = userStatuses;
        state.issueStatus = status;
        if(issue.avg){
            state.avg = issue.avg;
        }
        else{
            state.avg = null;
        }
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
