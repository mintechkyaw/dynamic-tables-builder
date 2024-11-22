import { createStore } from "vuex";
import Auth from "./modules/Auth";
import Forms from "./modules/Forms";


export default createStore({
    modules:{
        Auth,
        Forms,
    }
})
