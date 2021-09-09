export default {
    userIsRegistered (state, username) {
        state.userIsRegistered = true;
        state.username = username;
    },
    registerFailed (state) {
        state.userIsRegistered = false;
    },
}
