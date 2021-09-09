import auth from '../../services/api/auth'
import authStorage from "../../services/localStorage/authStorage";

export const signUp = ({ commit }, username) => {
    const response = auth.signUp(username);
    console.log(response)
    authStorage.setSession(response);
    commit('userIsRegistered');
}
