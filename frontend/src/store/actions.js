import lobby from '../services/api/lobby'

export const getIssue = ({ commit }) => {
    lobby.getIssue(issue => {
        commit('getIssue', issue)
    })
}

// export const sendMessage = ({ commit }, payload) => {
//     api.createMessage(payload, message => {
//         commit('receiveMessage', message)
//     })
// }
