import * as actions from '../actions'
import mutations from '../mutations'

const state = () => ({
    members: [],
    issue: 234
})

export default {
    namespaced: true,
    state,
    // getters,
    actions,
    mutations
}
