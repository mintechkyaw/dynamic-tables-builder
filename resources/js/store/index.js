import { createStore } from "vuex";
import Auth from "./modules/Auth";
import Forms from "./modules/Forms";
import Users from "./modules/Users";


export default createStore({
    modules:{
        Auth,
        Forms,
        Users
    }
})
