import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import home from './components/pages/home';
import tags from './components/pages/tags';

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
];


export default new Router({
    mode: 'history',
    routes
})
