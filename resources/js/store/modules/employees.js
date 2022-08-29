
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    employeeRequest: []
    
}
const getters = {

    getArrayEmployeeRequest(state, getters){
        return state.employeeRequest
    }
   
}

const actions = {
    async fetch({ commit }) {
        const response = await axios.get("/api/employeeslist")
        return response.data;
    },

    async fetchEmployeeRequest({ commit }) {
        const response = await axios.get("/api/employeesrequest")
        commit('setArrayEmployeeRequest', response.data)

        return response.data;
    },
}
const mutations = {
    setArrayEmployeeRequest (state, payload) {
        state.employeeRequest = payload
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}