
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    token: null,
    user: {}
}
const getters = {
    token: (state) => state.token,
    user: (state) => state.user
}

const actions = {
    async signIn({commit}, payload) {
        const res = axios.post("api/auth/login", payload)
        .then(
          function (response){
            // commit('setuserToken', response.data.data.token)
            // commit('setuserName', response.data.data.name)
            //router.push('/dashboard')
        }).catch((error) => {
         
        }); 
    }

}
const mutations = {
  
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}