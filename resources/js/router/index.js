import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../auth/LoginComponent.vue'

Vue.use(VueRouter)
const routes = [
    {
        path: '/',
        component: Login,
        name: 'Login'
    }
]

const router = new VueRouter({
    routes,
    mode: 'history'
})


export default router
