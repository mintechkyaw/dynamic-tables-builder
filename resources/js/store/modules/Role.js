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
        setRoles(state, roles) {
            state.roles = roles;
        },
    },
    actions: {
        async fetchRoles({ commit }) {
            try {
                const { data } = await api.get("/roles");
                // console.log(res);
                commit("setRoles", data.data);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async createRole({ commit }, role) {
            try {
                const { data } = await api.post("/roles", {
                    name: role,
                });
                // console.log(data);
                alert(data.message);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async deleteRole({ commit }, roleId) {
            try {
                const { data } = await api.delete(`/roles/${roleId}`);
                // console.log(res);
                alert(data.message);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
