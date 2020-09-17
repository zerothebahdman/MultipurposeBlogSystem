import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import home from './components/pages/home';
import tags from './admin/pages/tags';
import category from './admin/pages/category';

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
];


export default new Router({
    mode: 'history',
    routes
})
