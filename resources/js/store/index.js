import Vue from 'vue'
import Vuex from 'vuex'
import usersAPI from '../api/users'

Vue.use(Vuex);

export default new Vuex.Store({

    state: {
        users: null,
        isLoading: false,
        status: null
    },
    getters: {
        users: state => { return state.users },
        isLoading: state => { return state.isLoading },
        status: state => { return state.status },
    },
    mutations: {
        setUsers (state, users) {
            state.users = users
        },
        setIsLoading (state, isLoading) {
            state.isLoading = isLoading
        },
        setStatus (state, status) {
            state.status = status
        }
    },
    actions: {
        loadUsers ({ commit, state }) {
            commit('setIsLoading', true);
            return usersAPI.list()
                .then(response => {
                    commit('setUsers', response.data.data);
                    commit('setIsLoading', false);
                })
        },
        loadIsLoading ({ commit, state }, isLoading) {
            commit('setIsLoading', isLoading)
        },
        loadStatus ({ commit, state }, status) {
            commit('setStatus', status)
        }
    }
})
