import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import home from './components/pages/home';
import tags from './admin/pages/tags';
import category from './admin/pages/category';
import adminusers from './admin/pages/adminusers';
import login from './admin/pages/login';

const routes = [{
        path: '/',
        component: home,
        name: 'home'
    },
    {
        path: '/tags',
        component: tags,
        name: 'tags'
    },
    {
        path: '/category',
        component: category,
        name: 'categroy'
    },
    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers'
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
];


export default new Router({
    mode: 'history',
    routes
})
