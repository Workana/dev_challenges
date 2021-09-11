import router from "../../router/router";
import lobby from "../../services/api/lobby";
import {isError} from "../../helpers/isError";

const state = () => ({
    members: [],
    issue: null,
    issueStatus: '',
    avg: null,
})

const getters = {}

const actions = {
    joinIssue: async ({ commit, dispatch }, issue) => {
        dispatch('error/clearError', null, { root: true });
        const response = await lobby.joinIssue(issue)
        const { status } = response;
        if (!isError(status)) {
            commit('joinIssueSuccessful')
            await router.push(`/lobby/${issue}`)
        }
        else{
            dispatch('error/setError', `Something went wrong`, { root: true });
        }
    },
    getIssue: async ({ commit, dispatch }, issue) => {
        dispatch('error/clearError', null, { root: true });
        const response = await lobby.getIssue(issue);
        const { status, data } = response;
        if (!isError(status)) {
            commit('updateIssueSuccessful', data.payload)
        }
        else{
            dispatch('error/setError', `The issue doesn't exist`, { root: true });
            await router.push('/')
        }
    },
    updateIssue:({ commit }, data) => {
        commit('updateIssueSuccessful', data)
    },
    vote: async ({ commit, dispatch }, payload) => {
        dispatch('error/clearError', null, { root: true });
        const {issue, vote} = payload;
        const response = await lobby.vote(issue, vote);
        const { status } = response;
        if (!isError(status)) {
            commit('voteSuccesful')
        }
        else{
            dispatch('error/setError', `The vote couldn't be done`, { root: true });
        }
    }
}

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
