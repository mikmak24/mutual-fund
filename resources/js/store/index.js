import Vue from "vue";
import Vuex from "vuex";
import Axios from 'axios'
import authentication from './modules/authentication'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        authentication,
    },
    plugins: [createPersistedState()]
});

export default store