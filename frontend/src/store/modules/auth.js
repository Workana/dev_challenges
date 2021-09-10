import auth from "../../services/api/auth";
import {isError} from "../../helpers/isError";
import authStorage from "../../services/localStorage/authStorage";
import router from "../../router/router";

const state = () => ({
    userIsRegistered: false,
})

// getters
const getters = {}

// actions
const actions = {
    signUp: async ({ commit }, username) => {
        const response = await auth.signUp(username);

        const { status, data } = response;
        if (!isError(status)) {
            commit('registerSuccessful');
            authStorage.setSession(data.payload[0]);
            authStorage.setUsername(username);
            await router.push('/')
        }
        else{
            commit('registerFail');
        }
    }
}

// mutations
const mutations = {
    registerSuccessful (state) {
        state.userIsRegistered = true;
    },
    registerFail (state) {
        state.userIsRegistered = false;
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
