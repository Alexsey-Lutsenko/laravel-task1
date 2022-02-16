import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";
import store from "../index";

export default {
    namespaced: true,
    state() {
        return {
            fertilizers: [],
            errors: [],
            errorCount: 0,
        };
    },
    mutations: {
        addFertilizers(state, request) {
            state.fertilizers = request;
        },

        destroyFertilizer(state, payload) {
            const i = state.fertilizers.indexOf(state.fertilizers.find((item) => item.id === payload));
            if (i >= 0) {
                state.fertilizers.splice(i, 1);
            }
        },

        updateFertilizers(state, payload) {
            const i = state.fertilizers.indexOf(state.fertilizers.find((item) => item.id === payload.id));
            if (i >= 0) {
                state.fertilizers[i] = payload;
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
                const { data } = await axios.get("api/fertilizers");
                commit("addFertilizers", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/fertilizers", payload);
                dispatch("index");
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit }, payload) {
            try {
                await axios.delete(`api/fertilizers/${payload}`);
                commit("destroyFertilizer", payload);
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit }, payload) {
            try {
                await axios.patch(`api/fertilizers/${payload.id}`, payload);
                const culture = store.getters["culture/getCultures"].find((item) => item.id == payload.culture_id);
                payload.culture = culture.culture;
                commit("updateFertilizers", payload);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
    getters: {
        getFertilizers(state) {
            return state.fertilizers;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
};
