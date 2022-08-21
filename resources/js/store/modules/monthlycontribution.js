
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    
}
const getters = {
   
}

const actions = {
    async uploadContribution({commit}, payload) {
        const config = {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        };
        const response = await axios.post("api/uploadcontribution", payload,config)
        return response.data
    },

    async fetch({ commit }) {
        const response = await axios.get("/api/contributionlist")
        return response.data;
    },

    async fetchEmployeeContribution({ commit }) {
        const response = await axios.get("/api/fetchEmployeeContribution")
        return response.data;
    },

    async updateEmpContribution({commit}, payload) {
      console.log(payload)
      const response = await axios.post("api/updateContribution", payload)
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