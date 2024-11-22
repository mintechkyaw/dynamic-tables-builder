import api from "../../api/axios";

export default {
    state: {
        forms: [],
        form: [],
    },
    getters: {
        getForms(state) {
            return state.forms;
        },
        getForm(state) {
            return state.form;
        },
    },
    mutations: {
        setForms(state, forms) {
            state.forms = forms;
        },
        setForm(state, form) {
            state.form = form;
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
        async fetchFormById({ commit }, id) {
            try {
                const { data } = await api.get(`/forms/${id}`);
                commit("setForm", data.data);
            } catch (e) {
                throw new Error(e.response?.data?.message);
            }
        },
    },
};
