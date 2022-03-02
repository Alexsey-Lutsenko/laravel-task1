import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";
import store from "..";

export default {
    namespaced: true,
    state() {
        return {
            importStatuses: [],
            errors: [],
            errorCount: 0,
        };
    },
    mutations: {
        addImportStatus(state, request) {
            state.importStatuses = request;
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
        remuveError(state) {
            state.errorCount = 0;
            state.errors = [];
        },
    },
    actions: {
        async index({ commit }, page = 1) {
            try {
                const { data } = await axios.get("api/import-status?page=" + page);
                commit("addImportStatus", data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async store({ commit }, payload) {
            try {
                await axios.post("api/import-status", payload);
                if (payload.data == "Клиенты") {
                    store.commit("client/setMessage", payload.status);
                } else if (payload.data == "Удобрения") {
                    store.commit("fertilizer/setMessage", payload.status);
                }
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
    getters: {
        getImportStatuses(state) {
            return state.importStatuses;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
};
