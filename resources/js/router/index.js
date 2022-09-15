import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

//LoginPage
import Login from '../auth/LoginComponent.vue'

//AdminPages
import Dashboard from '../pages/admin/dashboard.vue'
import UploadMonthlyContribution from '../pages/admin/monthlycontribution.vue'
import ListOfEmployees from '../pages/admin/listofemployees.vue'
import ListOfContribution from '../pages/admin/listofcontribution.vue'
import ListOfRequest from '../pages/admin/listofrequest.vue'

import MasterAccount from '../pages/admin/masteraccount.vue';

//EmployeePages
import EmployeeDashboard from '../pages/employees/dashboard.vue'
import EmpListOfContribution from '../pages/employees/listofcontribution.vue'



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
    },
    {
        path: '/requestlist',
        component: ListOfRequest,
        name: 'ListOfRequest'
    },
    {
        path: '/masteraccount',
        component: MasterAccount,
        name: 'MasterAccount'
    },

    //Employees
    {
        path: '/empdashboard',
        component: EmployeeDashboard,
        name: 'EmployeeDashboard'
    },
    {
        path: '/empcontributionlist',
        component: EmpListOfContribution,
        name: 'EmpListOfContribution'
    },

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
