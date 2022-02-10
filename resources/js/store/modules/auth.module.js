
export default {
    namespaced: true,
    state() {
        return {
            token: null
        }
    },

    mutations: {

    },

    actions: {

    },

    getters: {
        token(state) {
            return state.token
        },
        isAuthenticated(_, getters) {
            return !getters.token
        }
    }
}

