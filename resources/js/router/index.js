import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'


//AdminPages
import Login from '../auth/LoginComponent.vue'
import Dashboard from '../pages/admin/dashboard.vue'
import UploadMonthlyContribution from '../pages/admin/monthlycontribution.vue'
import ListOfEmployees from '../pages/admin/listofemployees.vue'
import ListOfContribution from '../pages/admin/listofcontribution.vue'


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
    },
    {
        path: '/employeelist',
        component: ListOfEmployees,
        name: 'ListOfEmployees'
    },
    {
        path: '/contributionlist',
        component: ListOfContribution,
        name: 'ListOfContribution'
    }
]

const router = new VueRouter({
    routes,
    mode: 'history',
    base: process.env.BASE_URL,

})

// if (store.getters['authentication/isAuthenticated'] === false) {
//     router.replace('login')
// } else {
//     router.replace('dashboard')
// }
  
export default router
