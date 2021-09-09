import auth from '../../services/api/auth'
import {isError} from "../../helpers/isError";
import authStorage from "../../services/localStorage/authStorage";
import router from "../../router/router";

export const signUp = async ({ commit }, username) => {
    const response = await auth.signUp(username);

    const { status, data } = response;
    if (!isError(status)) {
        commit('userIsRegistered', username);
        authStorage.setSession(data.payload[0]);
        await router.push('/')
    }


}
