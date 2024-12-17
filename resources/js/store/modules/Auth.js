import api from "../../api/axios";
import { updateAbility } from "../../services/ability";
export default {
    state: {
        user: null,
    },
    getters: {
        authUser(state) {
            return state.user;
        },
    },
    mutations: {
        setAuthUser(state, user) {
            state.user = user;
        },
        clearUser(state) {
            state.user = null;
        },
    },
    actions: {
        async loginUser({ commit }, user) {
            try {
                const { data } = await api.post("/login", {
                    email: user.email,
                    password: user.password,
                });
                // commit("setAuthUser", data.user);
                localStorage.setItem("token", data.token);
                api.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${data.token}`;
                // console.log(data);
            } catch (e) {
                console.error("Login error:", e.message);
                throw new Error(
                    e.response?.data?.message ||
                        "Login failed. Please try again."
                );
            }
        },
        async authUserApi({ commit }) {
            try {
                const { data } = await api.get("/user");
                const user = data.data;
                commit("setAuthUser", user);
                if(user.permissions){
                    updateAbility(user.permissions);
                }else{
                    updateAbility([]);
                }
            } catch (e) {
                console.error("Login error:", e.message);
            }
        },
    },
};
