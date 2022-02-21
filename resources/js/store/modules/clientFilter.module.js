import axios from "axios";
import errorHandler from "../../utils/services/errorHandler";
import store from "../index";

const modelFilter = {
    client: "",
    purchaseFrom: null,
    purchaseTo: null,
    orderByClient: false,
    orderByPurchase: false,
    regions: [],
};

export default {
    namespaced: true,
    state() {
        return {
            filter: Object.assign({}, modelFilter),
            isFilter: !!localStorage.getItem("clientFilter"),
            errors: [],
            errorCount: 0,
        };
    },
    mutations: {
        addFilter(state, filter) {
            state.isFilter = true;
            state.filter = filter;
            localStorage.setItem("clientFilter", JSON.stringify(state.filter));
        },

        remuveFilter(state) {
            if (state.isFilter) {
                localStorage.removeItem("clientFilter");
                state.filter = Object.assign({}, modelFilter);
                state.isFilter = false;
                store.dispatch("client/index");
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
                state.filter = JSON.parse(localStorage.getItem("clientFilter"));
                if (state.filter.agreementDateFrom) {
                    state.filter.agreementDateFrom = new Date(state.filter.agreementDateFrom);
                }
                if (state.filter.agreementDateTo) {
                    state.filter.agreementDateTo = new Date(state.filter.agreementDateTo);
                }
                return state.filter;
            }
            return state.filter;
        },
        getIsFilter(state) {
            return state.isFilter;
        },
    },
};
