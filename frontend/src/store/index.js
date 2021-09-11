import Vue from 'vue'
import Vuex from 'vuex'
import auth from "./modules/auth";
import lobby from './modules/lobby';
import error from './modules/error';

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
        lobby,
        error,
    }
})
