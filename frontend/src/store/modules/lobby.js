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
    getIssue: async ({ commit, dispatch }, issue) => {
        dispatch('error/clearError', null, { root: true });
        const response = await lobby.getIssue(issue);
        const { status, data } = response;
        if (!isError(status)) {
            commit('UPDATE_ISSUE', data.payload)
        }
        else{
            dispatch('error/setError', `The issue doesn't exist`, { root: true });
            await router.push('/')
        }
    },
    updateIssue:({ commit }, data) => {
        commit('UPDATE_ISSUE', data)
    },
}

const mutations = {
    UPDATE_ISSUE: (state, issue) => {
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
