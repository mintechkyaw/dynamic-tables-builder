import { createStore } from "vuex";
import Auth from "./modules/Auth";
import Tables from "./modules/Tables";


export default createStore({
    modules:{
        Auth,
        Tables,
    }
})
