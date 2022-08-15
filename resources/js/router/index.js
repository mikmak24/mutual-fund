import Vue from 'vue'
import VueRouter from 'vue-router'

//Pages
import Login from '../auth/LoginComponent.vue'
import Dashboard from '../pages/dashboard/index.vue'
import UploadMonthlyContribution from '../pages/monthlycontribution/index.vue'


Vue.use(VueRouter)
const routes = [
    {
        path: '/',
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
    mode: 'history'
})


export default router
