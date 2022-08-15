
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    token: '',
    username: 'hahahah',
    credentials: []
}
const getters = {
    getUserCredential (state, getters) {
        return state.credentials
    }
}

const actions = {
    async signIn({commit}, payload) {
        const res = axios.post("api/auth/login", payload)
        .then(
          function (response){
            commit('setUserCredentials', response.data)
            
            router.push('/dashboard')
        }).catch((error) => {

            
        }); 
    },

    async logout({commit}, payload) {
        const res = axios.post("api/auth/logout", payload)
        .then(
          function (response){         
            commit('setUserCredentials', response.data)
            router.push('/')
        }).catch((error) => { 
        }); 
    }
}
const mutations = {
    setUserCredentials (state, payload) {
        state.credentials = payload

    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}