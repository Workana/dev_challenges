import auth from "../../services/api/auth";
import {isError} from "../../helpers/isError";
import authStorage from "../../services/localStorage/authStorage";
import router from "../../router/router";

const state = () => ({
    userIsRegistered: false,
})

const getters = {}

const actions = {
    signUp: async ({commit, dispatch}, username) => {
        dispatch('error/clearError', null, { root: true });
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
            dispatch('error/setError', `The username couldn't be registered`, { root: true });
        }
    }
}

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
