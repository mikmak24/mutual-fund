import Vue from 'vue'
import Axios from 'axios'
import router from './router/'
import store from './store/'

// Import Bootstrap and BootstrapVue CSS files (order is important)
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.prototype.$http = Axios;

Vue.component('App', require('./App.vue').default)

const app = new Vue({
    store,
    router,
    el: '#app',
    mode: 'history'
})