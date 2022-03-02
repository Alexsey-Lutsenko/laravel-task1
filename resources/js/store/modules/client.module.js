import axios from "axios";
import { root } from "postcss";
import errorHandler from "../../utils/services/errorHandler";
import store from "../index";

export default {
    namespaced: true,
    state() {
        return {
            clients: [],
            clientsDeleted: [],
            regions: [],
            errors: [],
            errorCount: 0,
            message: "",
        };
    },
    mutations: {
        addClients(state, request) {
            state.clients = request;

            state.regions = [];
            request.forEach((el) => {
                if (!state.regions.includes(el.region)) {
                    state.regions.push(el.region);
                }
            });
        },

        addClientsDeleted(state, request) {
            state.clientsDeleted = request;
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

        setMessage(state, payload) {
            state.message = payload;
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
        async index({ commit }, payload) {
            try {
                const { data } = await axios.get("api/clients", { params: payload });
                commit("addClients", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async indexDeleted({ commit }, page = 1) {
            try {
                const { data } = await axios.get("api/clients/deleted?page=" + page);
                commit("addClientsDeleted", data);
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

        async import({ commit }, payload) {
            try {
                await store.dispatch("importStatus/store", { status: "В процессе", user_id: payload.user_id, data: payload.data });
                await axios.post("api/clients/import", payload.formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                commit("remuveError");
            } catch (e) {
                await store.dispatch("importStatus/store", { status: "Ошибка во время импорта", user_id: payload.user_id, data: payload.data });
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
        getRegions(state) {
            return state.regions;
        },
        getClientsDeleted(state) {
            return state.clientsDeleted;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
        getMessage(state) {
            return state.message;
        },
    },
};
