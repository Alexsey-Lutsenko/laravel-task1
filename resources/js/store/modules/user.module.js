import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";
import store from "../index";

export default {
    namespaced: true,
    state() {
        return {
            users: [],
            errors: [],
            errorCount: 0,
            usersDeleted: [],
        };
    },
    mutations: {
        addUsers(state, requests) {
            state.users = requests;
        },

        addUsersDeleted(state, requests) {
            state.usersDeleted = requests;
        },

        updateUser(state, payload) {
            const i = state.users.indexOf(state.users.find((item) => item.id === payload.id));
            if (i >= 0) {
                state.users[i] = payload;
            }
        },

        destroyUsers(state, payload) {
            const i = state.users.indexOf(state.users.find((item) => item.id === payload));
            if (i >= 0) {
                state.users.splice(i, 1);
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

        remuveError(state) {
            state.errorCount = 0;
            state.errors = [];
        },
    },
    actions: {
        async index({ commit }) {
            try {
                const { data } = await axios.get("api/users");
                commit("addUsers", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async indexDeleted({ commit }) {
            try {
                const { data } = await axios.get("api/users/deleted");
                commit("addUsersDeleted", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/users", payload);
                dispatch("index");
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit }, payload) {
            try {
                await axios.patch(`api/users/${payload.id}`, payload);
                const role = store.getters["role/getRoles"].find((item) => item.id == payload.role_id);
                payload.role = role.role;
                commit("updateUser", payload);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit }, payload) {
            try {
                await axios.delete(`api/users/${payload}`);
                commit("destroyUsers", payload);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
    getters: {
        getUsers(state) {
            return state.users;
        },
        getUsersDeleted(state) {
            return state.usersDeleted;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
};
