import Vue from "vue";
import Vuex from "vuex";
import Axios from 'axios'
import createPersistedState from "vuex-persistedstate";
import authentication from './modules/authentication'
import monthlycontribution from './modules/monthlycontribution'



Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        authentication,
        monthlycontribution,
    },
    plugins: [createPersistedState()]
});

export default store