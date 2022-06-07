import Vue from "vue"
import Router from "vue-router"

Vue.use(Router);

import firstPage from "./components/pages/myfirstVuePage.vue"

import newRoutePage from "./components/pages/newRoutePage.vue"

import hooks from "./components/pages/basic/hooks.vue"

import methods from "./components/pages/basic/methods.vue"

//import pages

import tags from "./admin/pages/tags.vue"
import home from "./components/pages/home.vue"
import category from "./admin/pages/category.vue"
const routes = [


    //projects routes

    {
        path: '/',
        component: home ,
        
    },

    {
        path: '/tags',
        component: tags ,
        
    },
     {
        path: '/category',
        component: category ,
        
    },



    {
        path: '/my-new-vue-route',
        component: firstPage ,
        
    },


    //basic tutorial routes
    {
        path: '/new-route',
        component: newRoutePage 
    },
    {
        path: '/hooks',
        component: hooks 
    },
    {
        path: '/methods',
        component: methods
    }
]


export default new Router ({
    mode: 'history', //remove the dash 
    routes
});
