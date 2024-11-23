import api from "../../api/axios";

export default {
    state: {
        authUser: null,
    },
    getters: {
        authUser(state) {
            return state.authUser;
        },
    },
    mutations: {
        setAuthUser(state, user) {
            state.authUser = user;
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
                commit("setAuthUser", data.user);
                localStorage.setItem("token", data.token);
                api.defaults.headers.common["Authorization"] = `Bearer ${data.token}`;
                // console.log(data);
            } catch (e) {
                console.error("Login error:", e.message);
                throw new Error(
                    e.response?.data?.message ||
                        "Login failed. Please try again."
                );
            }
        },
    },
};
