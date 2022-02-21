import Vuex from "vuex";
import auth from "./modules/auth.module";
import user from "./modules/user.module";
import role from "./modules/role.module";
import culture from "./modules/culture.module";
import client from "./modules/client.module";
import fertilizer from "./modules/fertilizer.module";
import clientFilter from "./modules/clientFilter.module";

export default new Vuex.Store({
    modules: {
        auth,
        user,
        role,
        culture,
        client,
        fertilizer,
        clientFilter,
    },
});
