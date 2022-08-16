
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    token: '',
    username: '',
    isAuthenticated: false,
    credentials: []
}
const getters = {
    getUserCredential (state, getters) {
        return state.credentials
    },
    isAuthenticated(state, getters){
        return state.isAuthenticated
    }
}

const actions = {
    async signIn({commit}, payload) {
        const response = await axios.post("api/auth/login", payload)
        if(response.data.status === 'SUCCESS'){
            commit('setUserCredentials', response.data)
            commit('setIsAuthenticated', true)

        } else {
            commit('setUserCredentials', response.data)
            commit('setIsAuthenticated', false)
        }
        return response.data
    },

    async logout({commit}) {
        const res = axios.post("api/auth/logout")
        .then(
          function (response){         
            commit('setUserCredentials', response.data)
            commit('setIsAuthenticated', false)

            router.push('/')
        }).catch((error) => { 
        }); 
    }
}
const mutations = {
    setUserCredentials (state, payload) {
        state.credentials = payload
    },

    setIsAuthenticated(state, payload){
        state.isAuthenticated = payload

    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}