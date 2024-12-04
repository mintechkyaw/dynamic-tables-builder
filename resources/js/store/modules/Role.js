import api from "../../api/axios";

export default {
    state: {
        roles: null,
    },
    getters: {
        getRoles(state) {
            return state.roles;
        },
    },
    mutations: {
        setRole(state, roles) {
            state.roles = roles;
        },
    },
    actions: {
        async fetchRoles({ commit }) {
            try {
                const res = await api.get("/roles");
                console.log(res);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async createRole({ commit }, role) {
            try {
                const res = await api.post("/roles", role);
                console.log(res);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
