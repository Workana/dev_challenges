import auth from '../../services/api/auth'

export const signUp = ({ commit }, username) => {
    auth.signUp(username);
    commit('userIsRegistered');
}
