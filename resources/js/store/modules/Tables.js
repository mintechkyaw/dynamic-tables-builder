// store/modules/tables.js
import api from "../../api/axios";

const state = {
    tables: [],
};

const mutations = {
    SET_TABLES(state, tables) {
        state.tables = tables;

    },
};

const actions = {
    async fetchTables({ commit }) {
        const res = await api.get("/forms/", {
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        commit("SET_TABLES", res.data.data);
    },
};

const getters = {
    tables: (state) => state.tables,
};

export default {
    state,
    mutations,
    actions,
    getters,
};
