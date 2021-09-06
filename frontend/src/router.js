import Vue from "vue";
import Router from "vue-router";
import Lobby from "./views/Lobby";
import Home from "./views/Home";

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/lobby',
            name: 'Lobby',
            component: Lobby
        }
    ]
})
