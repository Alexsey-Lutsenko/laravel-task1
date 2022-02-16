import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            cultures: [],
            errors: [],
            errorCount: 0,
        };
    },
    mutations: {
        addCultures(state, request) {
            state.cultures = request;
        },

        destroyCulture(state, payload) {
            const i = state.cultures.indexOf(state.cultures.find((item) => item.id === payload));
            if (i >= 0) {
                state.cultures.splice(i, 1);
            }
        },

        updateCultures(state, payload) {
            const i = state.cultures.indexOf(state.cultures.find((item) => item.id === payload.id));
            if (i >= 0) {
                state.cultures[i] = payload;
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
                const { data } = await axios.get("api/cultures");
                commit("addCultures", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/cultures", payload);
                dispatch("index");
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit }, payload) {
            try {
                await axios.delete(`api/cultures/${payload}`);
                commit("destroyCulture", payload);
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit }, payload) {
            try {
                await axios.patch(`api/cultures/${payload.id}`, payload);
                commit("updateCultures", payload);
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
    getters: {
        getCultures(state) {
            return state.cultures;
        },

        getErrors(state) {
            return state.errors;
        },

        getErrorCount(state) {
            return state.errorCount;
        },
    },
};
