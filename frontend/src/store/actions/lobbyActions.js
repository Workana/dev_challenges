import lobby from '../../services/api/lobby'

export const getIssue = ({ commit }) => {
    lobby.getIssue(issue => {
        commit('getIssue', issue)
    })
}
