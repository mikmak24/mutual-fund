import Vue from "vue";
import Vuex from "vuex";
import Axios from 'axios'
import createPersistedState from "vuex-persistedstate";
import authentication from './modules/authentication'
import monthlycontribution from './modules/monthlycontribution'
import employees from './modules/employees'
import masteraccount from './modules/masteraccount'


Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        authentication,
        monthlycontribution,
        employees,
        masteraccount
    },
    plugins: [createPersistedState()]
});

export default store