const state = () => ({
    isError: false,
    message: '',
})

const getters = {}

const actions = {
    setError: ({ commit }, message) => {
        commit('setError', message);
    },
    clearError: ({ commit }) => {
        commit('clearError');
    }
}

const mutations = {
    setError (state, message) {
        state.isError = true;
        state.message = message;
    },
    clearError (state) {
        state.isError = false;
        state.message = '';
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
