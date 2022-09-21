
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
        return response.data;
        commit('setArrayEmployeeRequest', response.data)
    },

    async fetchChartData({ commit }) {
        const response = await axios.get("/api/fetchChartData")
        return response.data;
        // commit('setArrayEmployeeRequest', response.data)
    },

    async acceptEmpContribution({commit}, payload) {
        const response = await axios.post("api/acceptContribution", payload)
        return response.data
    },

    async declineEmpContribution({commit}, payload) {
        const response = await axios.post("api/declineContribution", payload)
        return response.data
    },

    async updateEmployeeStatus({commit}, payload) {
        const response = await axios.post("api/updateEmployeeStatus", payload)
        return response.data
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