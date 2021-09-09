import lobby from '../../services/api/lobby'

export const joinIssue = ({ commit }, issue) => {
    lobby.joinIssue(issue)
    commit('joinedIssueSuccesfully')
}

export const getIssue = ({ commit }) => {
    lobby.getIssue(issue => {
        commit('getIssue', issue)
    })
}
