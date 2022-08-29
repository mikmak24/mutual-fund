
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    employeeRequest: [],
    employeeList: []

    
}
const getters = {

    getArrayEmployeeRequest(state, getters){
        return state.employeeRequest
    },

    getArrayEmployeeList(state, getters){
        return state.employeeList
    }
   
}

const actions = {
    async fetch({ commit }) {
        const response = await axios.get("/api/employeeslist")
        commit('setArrayEmployeeList', response.data)
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

    setArrayEmployeeList (state, payload) {
        state.employeeList = payload
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}