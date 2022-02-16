import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            clients: [],
            errors: [],
            errorCount: 0,
        };
    },
    mutations: {
        addClients(state, request) {
            state.clients = request;
        },

        destroyClient(state, payload) {
            const i = state.clients.indexOf(state.clients.find((item) => item.id === payload));
            if (i >= 0) {
                state.clients.splice(i, 1);
            }
        },

        updateClients(state, payload) {
            const i = state.clients.indexOf(state.clients.find((item) => item.id === payload.id));
            if (i >= 0) {
                state.clients[i] = payload;
            }
        },

        addErrors(state, requests) {
            state.errorCount = 1;
            state.errors = requests;
            if (requests.message) {
                console.error("ERROR: ", requests.message);
            }
        },

        remuveError(state) {
            state.errorCount = 0;
            state.errors = [];
        },
    },
    actions: {
        async index({ commit }) {
            try {
                const { data } = await axios.get("api/clients");
                commit("addClients", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/clients", payload);
                dispatch("index");
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit }, payload) {
            try {
                await axios.delete(`api/clients/${payload}`);
                commit("destroyClient", payload);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit }, payload) {
            try {
                await axios.patch(`api/clients/${payload.id}`, payload);
                commit("updateClients", payload);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
    getters: {
        getClients(state) {
            return state.clients;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
};
