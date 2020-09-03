import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import home from './components/pages/home'

const routes = [{
    path: '/',
    component: home,
    name: 'home'
}, ]


export default new Router({
    mode: 'history',
    routes
})
