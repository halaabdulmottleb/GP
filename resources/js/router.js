import Vue from "vue";
import VueRouter from "vue-router";
import CoreuiVue from '@coreui/vue';
import Home from "./views/Home.vue";
import About from "./views/about.vue";
import dashboard from "./views/dashboard.vue";
import login from "./views/pages/login.vue";
import users from "./views/users/Users.vue";


Vue.use(VueRouter);
Vue.use(CoreuiVue)


const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
       
    },

     {
        path: "/about",
        name: "about",
        component: About,
       
    },
     {
         path: "/dashboard",
         name: "dashboard",
         component: dashboard,
       
    },

    {
        path: "/login",
         name: "login",
         component: login,
       
    },
    {
        path: "/users",
        name: "users",
        component: users,
       
    }

    
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
