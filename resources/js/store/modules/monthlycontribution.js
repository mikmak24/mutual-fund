
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

    async updateContribution ({commit}, payload) {
        console.log(payload)
        const response = await axios.post("api/modifyContribution", payload)
        return response.data
    },

    async fetch({ commit }) {
        const response = await axios.get("/api/contributionlist")
        commit('setArrayContributionList', response.data)
        return response.data;
    },

    async fetchEmployeeContribution({ commit }) {
        const response = await axios.get("/api/fetchEmployeeContribution")
        return response.data;
        commit('setArrayOfEmpContributionList', response.data)
    },

    async updateEmpContribution({commit}, payload) {
      const response = await axios.post("api/updateEmpContribution", payload)
      return response.data
    },

    async fetchEmpDashboardCardDetails({ commit }) {
        const response = await axios.get("/api/fetchEmpDashboardCardDetails")
        commit('setMonthlyContribution', response.data)
        return response.data
    },

    async downloadEmployees({ commit }) {
        const response = await axios.get("/api/downloadEmployees")
        return response.data;
    },

    async countContributionRequest({ commit }) {
        const response = await axios.get("/api/countContributionRequest")
        return response.data;
    },

    async removeState({ commit }) {
        commit('setStatetoEmpty')
    },

    async fetchIndvContribution({commit}, payload) {
        const response = await axios.post("/api/fetchIndvContribution", payload)
        return response.data;
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

    setStatetoEmpty(state){
        state.monthlyContribution =  0,
        state.totalEmployeeContr =  0,
        state.totalEmployerContr =  0,
        state.totalMonthContr =  0
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}