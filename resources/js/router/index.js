import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'


//Pages
import Login from '../auth/LoginComponent.vue'
import Dashboard from '../pages/dashboard/index.vue'
import UploadMonthlyContribution from '../pages/monthlycontribution/index.vue'


Vue.use(VueRouter)
const routes = [
    {
        path: '/',
        redirect: '/login'
    },
    {
        path: '/login',
        component: Login,
        name: 'Login'
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'Dashboard'
    },
    {
        path: '/uploadcontribution',
        component: UploadMonthlyContribution,
        name: 'UploadMonthlyContribution'
    }
]

const router = new VueRouter({
    routes,
    mode: 'history',
    base: process.env.BASE_URL,

})

if (store.getters['authentication/isAuthenticated'] === false) {
    router.replace('login')
} else {
    router.replace('dashboard')
}
  
export default router
