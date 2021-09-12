const state = () => ({
    isError: false,
    message: '',
})

const getters = {}

const actions = {
    setError: ({ commit }, message) => {
        commit('SET_ERROR', message);
    },
    clearError: ({ commit }) => {
        commit('CLEAR_ERROR');
    }
}

export const mutations = {
    SET_ERROR(state, message) {
        state.isError = true;
        state.message = message;
    },
    CLEAR_ERROR(state) {
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
