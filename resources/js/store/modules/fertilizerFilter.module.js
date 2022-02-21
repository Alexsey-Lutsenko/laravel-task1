import store from "../index";

export default {
    namespaced: true,
    state() {
        return {
            filter: {},
            isFilter: false,
            errors: [],
            errorCount: 0,
        };
    },
    mutations: {
        addFilter(state, filter) {
            state.isFilter = true;
            state.filter = filter;
        },

        remuveFilter(state) {
            if (state.isFilter) {
                state.filter = {};
                state.isFilter = false;
                store.dispatch("fertilizer/index");
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
    actions: {},
    getters: {
        getFilter(state) {
            if (state.isFilter) {
                return state.filter;
            }
            return state.filter;
        },
        getIsFilter(state) {
            return state.isFilter;
        },
    },
};
