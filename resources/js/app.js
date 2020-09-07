/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import router from "./router";

Vue.component("mainapp", require("./components/Mainapp.vue").default);
Vue.component("navigation", require("./components/pages/Navigation.vue").default);

import vuetify from "./vuetify";

// import App from './App.vue'

const app = new Vue({
    el: "#app",
    vuetify,
    router
});
