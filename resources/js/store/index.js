import axios from 'axios';
import { createStore } from 'vuex'

export default createStore({
    state() {
        return {
            teams: [],
            standings: [],
            games: [],
            lastGames: [],
            nextGames: [],
            winners: [],
            status: null,
        }
    },
    mutations: {
        setTeams(state, payload) {
            state.teams = payload;
        },
        setStandings(state, payload) {
            state.standings = payload;
        },
        setGames(state, payload) {
            state.games = payload;
        },
        setLastGames(state, payload) {
            state.lastGames = payload;
        },
        setNextGames(state, payload) {
            state.nextGames = payload;
        },
        setWinners(state, payload) {
            state.winners = payload;
        },
        setStatus(state, payload) {
            state.status = payload;
        }
    },

    actions: {
        getStatus({commit}) {
            axios.get('/api/status').then((res) => {
                commit('setStatus', res.data);
            }).catch((err) => {
                alert(err);
            })
        },
        getTeams({commit, state}) {
            if (state.teams.length > 0){
                return;
            }
            axios.get('/api/teams').then((res) => {
                commit('setTeams', res.data);
            }).catch((err) => {
                alert(err);
            })
        },
        getGames({commit}) {
            axios.get('/api/games').then((res) => {
                commit('setGames', res.data);
            }).catch((err) => {
                alert(err);
            })
        },
        getStandings({commit}) {
            axios.get('/api/standings').then((res) => {
                commit('setStandings', res.data);
            }).catch((err) => {
                alert(err);
            })
        },
        getNextGames({commit}) {
            axios.get('/api/games/next').then((res) => {
                commit('setNextGames', res.data);
            }).catch((err) => {
                alert(err);
            })
        },
        getLastGames({commit}) {
            axios.get('/api/games/last').then((res) => {
                commit('setLastGames', res.data);
            }).catch((err) => {
                alert(err);
            })
        },
        getWinners({commit}) {
            axios.get('/api/winners').then((res) => {
                commit('setWinners', res.data);
            }).catch((err) => {
                alert(err);
            })
        }

    },
})
