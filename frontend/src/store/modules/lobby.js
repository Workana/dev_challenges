import * as actions from '../actions/lobbyActions'
import mutations from '../mutations/lobbyMutations'

const state = () => ({
    members: [],
    issue: null,
    issueStatus: '',
})

export default {
    namespaced: true,
    state,
    // getters,
    actions,
    mutations
}