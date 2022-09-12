
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    token: '',
    username: '',
    isAuthenticated: false,
    credentials: [],
    isAdmin: false,
    dollarToday: '',
    numberOfEmp: 0
}
const getters = {
    getUserCredential (state, getters) {
        return state.credentials
    },
    isAuthenticated(state, getters){
        return state.isAuthenticated
    },
    isAdmin(state, getters){
        return state.isAdmin
    },
    getCurrentDollar(state, getters){
        return state.dollarToday
    },

    getNumberOfEmp(state, getters){
        return state.numberOfEmp
    },

}

const actions = {
    async signIn({commit}, payload) {
        const response = await axios.post("api/auth/login", payload)
        if(response.data.status === 'SUCCESS'){
            commit('setUserCredentials', response.data)
            commit('setIsAuthenticated', true)
            commit('setIsAdmin', response.data.isAdmin)
            commit('setDollar',  response.data.dollarToday)
            commit('setNumberOfEmployee',  response.data.numberOfEmp)
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
            commit('setIsAdmin', false)
            
            return response.data
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

    },

    setIsAdmin(state, payload){
        state.isAdmin = payload
    },

    setDollar(state, payload){
        state.dollarToday = payload
    },

    setNumberOfEmployee(state, payload){
        state.numberOfEmp = payload
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}