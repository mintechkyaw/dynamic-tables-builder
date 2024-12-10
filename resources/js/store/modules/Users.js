import api from "../../api/axios";

export default {
    state: {
        users: null,
    },
    getters: {
        getUsers(state) {
            return state.users;
        },
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
    },
    actions: {
        async fetchUsers({ commit }, params) {
            try {
                const { data } = await api.get("/users", params);
                // console.log(data);
                commit("setUsers", data.data);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async createUser({ commit }, user) {
            try {
                const { data } = await api.post("/users", user);
                // console.log(res);
                alert(data.message);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async fetchUserById({ commit }, id) {
            try {
                const res = await api.get(`/users/${id}`);
                // console.log(data);
                // commit("setUsers", data.data);
                console.log(res);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
