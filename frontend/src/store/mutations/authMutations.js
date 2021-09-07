export default {
    userIsRegistered (state) {
        state.userIsRegistered = true;
    },
    registerFailed (state) {
        state.userIsRegistered = false;
    },
}
