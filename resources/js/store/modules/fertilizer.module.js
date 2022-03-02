import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";
import store from "../index";

export default {
    namespaced: true,
    state() {
        return {
            fertilizers: [],
            fertilizersDeleted: [],
            errors: [],
            errorCount: 0,
            regions: [],
            cultures: [],
            message: "",
        };
    },
    mutations: {
        addFertilizers(state, request) {
            state.fertilizers = request;

            state.regions = [];
            request.forEach((el) => {
                if (!state.regions.includes(el.region)) {
                    state.regions.push(el.region);
                }
            });
            state.cultures = [];

            request.forEach((el) => {
                const i = state.cultures.indexOf(state.cultures.find((item) => item.id === el.culture_id));

                if (i < 0) {
                    state.cultures.push({
                        id: el.culture_id,
                        culture: el.culture,
                    });
                }
            });
        },

        addFertilizersDeleted(state, request) {
            state.fertilizersDeleted = request;
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
                const { data } = await axios.get("api/fertilizers", { params: payload });
                commit("addFertilizers", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async indexDeleted({ commit }, page) {
            try {
                const { data } = await axios.get("api/fertilizers/deleted?page=" + page);
                commit("addFertilizersDeleted", data);
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

        async import({ commit }, payload) {
            try {
                await store.dispatch("importStatus/store", { status: "В процессе", user_id: payload.user_id, data: payload.data });
                await axios
                    .post("api/fertilizers/import", payload.formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then(async (res) => {
                        if (res.data.errorsImport) {
                            await store.dispatch("importStatus/store", {
                                status: res.data.messages,
                                errors_array: res.data.errorsImport,
                                user_id: payload.user_id,
                                data: payload.data,
                            });
                        } else {
                            await store.dispatch("importStatus/store", { status: res.data.messages, user_id: payload.user_id, data: payload.data });
                        }
                    });
                commit("remuveError");
            } catch (e) {
                await store.dispatch("importStatus/store", { status: "Ошибка во время импорта", user_id: payload.user_id, data: payload.data });
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
        getRegions(state) {
            return state.regions;
        },
        getCultures(state) {
            return state.cultures;
        },
        getFertilizersDeleted(state) {
            return state.fertilizersDeleted;
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
