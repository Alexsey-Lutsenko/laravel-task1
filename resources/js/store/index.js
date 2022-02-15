import Vuex from "vuex";
import auth from "./modules/auth.module"
import user from "./modules/user.module"
import role from "./modules/role.modules";

export default new Vuex.Store({
    modules: {
        auth,
        user,
        role
    }
})
