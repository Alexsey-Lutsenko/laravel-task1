import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            admin: {},
            isAuthenticated: localStorage.getItem("isAuthenticated"),
            isAuthenticatedError: "",
            errors: [],
            errorCount: 0,
        };
    },

    mutations: {
        addAdmin(state, request) {
            state.admin = request;
        },

        isAuthenticated(state, request) {
            state.isAuthenticated = request;
            if (state.isAuthenticated) {
                localStorage.setItem("isAuthenticated", true);
            }
        },

        logout(state) {
            state.isAuthenticated = null;
            localStorage.removeItem("isAuthenticated");
        },

        addIsAuthenticatedError(state) {
            state.isAuthenticatedError = "Данные для входа в систему неверные";
        },

        remuveIsAuthenticatedError(state) {
            state.isAuthenticatedError = "";
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
        async getAdmin({ commit }) {
            try {
                const { data } = await axios.get("/api/users/create-admin");
                commit("addAdmin", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async isLogin({ commit }, payload) {
            try {
                commit("remuveIsAuthenticatedError");
                const { data } = await axios.post("/api/users/create-admin", payload);

                data.data.isLogin ? commit("isAuthenticated", data.data.isLogin) : commit("addIsAuthenticatedError");
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },

    getters: {
        getAdmin(state) {
            return state.admin;
        },
        isAuthenticated(state) {
            return state.isAuthenticated;
        },
        getIsAuthenticatedError(state) {
            return state.isAuthenticatedError;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
};
