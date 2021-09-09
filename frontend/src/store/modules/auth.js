import * as actions from '../actions/authActions'
import mutations from '../mutations/authMutations'

const state = () => ({
    userIsRegistered: false,
    username: '',
})

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
