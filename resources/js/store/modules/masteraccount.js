
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    value: 0
    
}
const getters = {

    getMasterAccountValue(state, getters){
        return state.value
    }
   
}

const actions = {
    async fetch({ commit }) {
        const response = await axios.get("/api/masteraccount")
        commit('setMasterAccountValue', response.data)
        return response.data

    },

    async updateMasterAccount({commit}, payload) {
        const response = await axios.post("api/updateMasterAccount", payload)

        return response.data
    },
}
const mutations = {

    setMasterAccountValue (state, payload) {
        state.value = payload[0].master_account_amount
    },
  
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}