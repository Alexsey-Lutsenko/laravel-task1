import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            cultures: [],
            culturesDeleted: [],
            errors: [],
            errorMessage: "",
            errorMessageTimeout: 2000,
            errorCount: 0,
        };
    },
    mutations: {
        addCultures(state, request) {
            state.cultures = request;
        },

        addCulturesDeleted(state, request) {
            state.culturesDeleted = request;
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
            if (requests.errors) {
                state.errorCount = 1;
            }
            state.errors = requests.errors;
            if (requests.message) {
                console.error("ERROR: ", requests.message);
            }
        },

        addErrorMessage(state, request) {
            state.errorMessage = request.message;
        },

        remuveErrorMessage(state) {
            state.errorMessage = "";
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

        async indexDeleted({ commit }) {
            try {
                const { data } = await axios.get("api/cultures/deleted");
                commit("addCulturesDeleted", data.data);
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

        async destroy({ state, commit }, payload) {
            try {
                await axios.delete(`api/cultures/${payload}`);
                commit("destroyCulture", payload);
            } catch (e) {
                commit("addErrors", errorHandler(e));
                commit("addErrorMessage", errorHandler(e));
                setTimeout(() => {
                    commit("remuveErrorMessage");
                }, state.errorMessageTimeout);
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

        getCulturesDeleted(state) {
            return state.culturesDeleted;
        },

        getErrors(state) {
            return state.errors;
        },

        getErrorMessage(state) {
            return state.errorMessage;
        },

        getErrorCount(state) {
            return state.errorCount;
        },

        getErrorMessageTimeout(state) {
            return state.errorMessageTimeout;
        },
    },
};
