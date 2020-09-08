/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import router from "./router";
import common from "./common";
import moment from "moment";
import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Toast = Toast;

// Use filter to transform text to uppercase
Vue.filter("upText", function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});
// Use Moment.js to format date better
Vue.filter("myDate", function(created) {
    return moment(created).format("MMMM Do YYYY");
});

Vue.mixin(common);

Vue.component("mainapp", require("./components/Mainapp.vue").default);
Vue.component(
    "navigation",
    require("./components/pages/Navigation.vue").default
);

import vuetify from "./vuetify";

// import App from './App.vue'

const app = new Vue({
    el: "#app",
    vuetify,
    router
});
