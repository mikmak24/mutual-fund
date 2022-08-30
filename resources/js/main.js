import Vue from 'vue'
import Axios from 'axios'
import router from './router/'
import store from './store/'

import FlashMessage from '@smartweb/vue-flash-message';
import JsonExcel from "vue-json-excel";

// Import Bootstrap and BootstrapVue CSS files (order is important)
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';




Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(FlashMessage);
Vue.use(VueLoading)
Vue.prototype.$http = Axios;

Vue.component('App', require('./App.vue').default)
Vue.component("downloadExcel", JsonExcel);
Vue.component("PulseLoader", PulseLoader);


const app = new Vue({
    store,
    router,
    el: '#app',
    mode: 'history'
})