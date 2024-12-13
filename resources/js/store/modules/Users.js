import api from "../../api/axios";

export default {
    state: {
        users: null,
        user: null,
    },
    getters: {
        getUsers(state) {
            return state.users;
        },
        getUser(state) {
            return state.user;
        },
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
        setUser(state, user) {
            state.user = user;
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
                const { data } = await api.get(`/users/${id}`);
                // console.log(data);
                commit("setUser", data.data);
                // console.log(res);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async deleteUser({ commit }, id) {
            try {
                const { data } = await api.delete(`/users/${id}`);
                // console.log(res);
                alert(data.message);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async updateUser({ commit }, user) {
            try {
                const {data} = await api.patch(`/users/${user.id}`, {
                    name: user.name,
                    // email: user.email,
                    permissions: user.updatePermissions,
                });
                // console.log(res);
                alert(data.message);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
