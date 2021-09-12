import Vue from "vue";
import Router from "vue-router";
import Lobby from "../views/Lobby.vue";
import Home from "../views/Home.vue";
import SignUp from "../views/SignUp.vue";

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/signup',
        name: 'SignUp',
        component: SignUp
    },
    {
        path: '/lobby/:issue',
        name: 'Lobby',
        component: Lobby
    }
];

export default new Router({routes});
