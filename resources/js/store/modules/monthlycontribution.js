
import axios from 'axios'
import {store} from '../index'
import router from '../../router';

const state = {
    monthlyContribution: 0,
    totalEmployeeContr: 0,
    totalEmployerContr: 0,
    totalMonthContr: 0,
    contributionList: [],
    empContributionList: []


    
}
const getters = {
    getmonthlyContribution(state, getters){
        return state.monthlyContribution
    },

    gettotalEmployeeContr(state, getters){
        return state.totalEmployeeContr
    },

    gettotalEmployerContr(state, getters){
        return state.totalEmployerContr
    },

    gettotalMonthContr(state, getters){
        return state.totalMonthContr
    },

    getArrayOfContributions(state, getters){
        return state.contributionList
    },

    getArrayOfEmployeeContributions(state, getters){
        return state.empContributionList
    }
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
        commit('setArrayContributionList', response.data)
        return response.data;
    },

    async fetchEmployeeContribution({ commit }) {
        const response = await axios.get("/api/fetchEmployeeContribution")
        commit('setArrayOfEmpContributionList', response.data)
        return response.data;
    },

    async updateEmpContribution({commit}, payload) {
      const response = await axios.post("api/updateContribution", payload)
      return response.data
    },

    async fetchEmpDashboardCardDetails({ commit }) {
        const response = await axios.get("/api/fetchEmpDashboardCardDetails")
        commit('setMonthlyContribution', response.data)
    },
}
const mutations = {

    setMonthlyContribution (state, payload) {
        state.monthlyContribution =  payload[0].employee_monthly_contribution
        state.totalEmployeeContr =  payload[0].total_employee_contr
        state.totalEmployerContr =  payload[0].total_employer_contr
        state.totalMonthContr =  payload[0].total_month_contr
    },

    setArrayContributionList (state, payload) {
        state.contributionList = payload
    },

    setArrayOfEmpContributionList (state, payload) {
        state.empContributionList = payload
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}