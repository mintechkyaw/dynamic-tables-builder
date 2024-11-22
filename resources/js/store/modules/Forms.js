import api from "../../api/axios";

export default {
    state: {
        forms: [],
    },
    getters: {
        getForms(state) {
            return state.forms;
        },
    },
    mutations: {
        setForms(state, forms) {
            state.forms = forms;
        },
    },
    actions: {
        async fetchForms({ commit }) {
            try {
                const { data } = await api.get("/forms");
                commit("setForms", data.data);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
        async createForm({ commit }, form) {
            try {
                const { data } = await api.post("/forms", {
                    name: form.formName,
                    slug: form.slug,
                });
                console.log(data);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
