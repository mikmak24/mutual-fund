
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    
}
const getters = {
   
}

const actions = {
    async fetch({ commit }) {
        const response = await axios.get("/api/masteraccount")
        return response.data;
    },

    async updateMasterAccount({commit}, payload) {
        console.log(payload)
        const response = await axios.post("api/updateMasterAccount", payload)
        return response.data
    },
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