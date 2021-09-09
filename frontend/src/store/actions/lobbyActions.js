import lobby from '../../services/api/lobby'
import router from "../../router/router";

export const joinIssue = ({ commit }, issue) => {
    lobby.joinIssue(issue)
    commit('joinedIssueSuccesfully')
    router.push(`/lobby/${issue}`)
}

export const getIssue = async ({ commit }, issue) => {
    const res = await lobby.getIssue(issue);
    commit('getIssue', res.data.payload)
}

export const updateIssue = ({ commit }, data) => {
    commit('getIssue', data)
}

export const vote = async ({ commit }, payload) => {
    const {issue, vote} = payload;
    const res = await lobby.vote(issue, vote);
    console.log(res)
    commit('voteSuccesful')
}
