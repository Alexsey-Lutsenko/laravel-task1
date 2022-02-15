import errorHandler from "../../utils/services/errorHandler"

export default {
    namespaced: true,
    state() {
        return {
            roles: []
        }
    },
    mutations: {
        setRoles(state, request) {
            state.roles = request
        }
    },
    actions: {
        async index({commit}) {
            try {
                const {data} = await axios.get('api/roles')
                commit('setRoles', data.data)
            } catch (e) {
                console.log(errorHandler(e));
            }
            
        }
    },
    getters: {
        getRoles(state) {
            return state.roles
        }
    }
}
