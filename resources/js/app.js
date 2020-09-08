/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import router from "./router";
import common from "./common";

import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
window.Toast = Toast;

Vue.mixin(common)

Vue.component("mainapp", require("./components/Mainapp.vue").default);
Vue.component("navigation", require("./components/pages/Navigation.vue").default);

import vuetify from "./vuetify";

// import App from './App.vue'

const app = new Vue({
    el: "#app",
    vuetify,
    router
});
