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
        async fetchUsers({ commit }) {
            try {
                const res = await api.get("/users");
                console.log(res);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async createUser({ commit }, user) {
            try {
                const res = await api.post("/users", user);
                console.log(res);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
