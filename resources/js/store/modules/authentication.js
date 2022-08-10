
import axios from 'axios'
import {store} from '../index'
const state = {
    token: null,
    user: {}
}
const getters = {
    token: (state) => state.token,
    user: (state) => state.user
}

const actions = {
    async signIn() {
        console.log('JESUSSSSSS')
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