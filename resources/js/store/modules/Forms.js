import api from "../../api/axios";

export default {
    state: {
        forms: [],
        form: {},
        responseForms : null,
    },
    getters: {
        getForms(state) {
            return state.forms;
        },
        getForm(state) {
            return state.form;
        },
        getResponseForms(state) {
            return state.responseForms;
        }
    },
    mutations: {
        setForms(state, forms) {
            state.forms = forms;
        },
        setForm(state, form) {
            state.form = form;
        },
        updateForms(state, newForm) {
            state.forms.push(newForm);
        },
        responseForms(state, responseForms) {
            state.responseForms = responseForms;
        }
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
        async fetchResponseTables({commit}, id) {
            try {
                const { data } = await api.get(`/forms/${id}/data`);
                commit("responseForms", data);
            } catch (error) {

            }
        },
        async createForm({ commit }, form) {
            try {
                const { data } = await api.post("/forms", {
                    name: form.formName,
                    slug: form.slug,
                });
                // console.log(data);
                commit("updateForms", data.form);
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
        async submitFormField({ commit }, fieldData) {
            try {
                const res = await api.post(`/form_fields`, fieldData);
                // console.log(res);
                alert(res.data.message);
            } catch (e) {
                alert(e.response?.data?.message);
                throw new Error(e.response?.data?.message);
            }
        },
        async deleteField({ commit }, id) {
            try {
                const res = await api.delete(`/form_fields/${id}`);
                // console.log(res);
                alert(res.data.message);
            } catch (e) {
                alert(e.response?.data?.message);
                throw new Error(e.response?.data?.message);
            }
        },
        async submitFormToDatabase({ commit }, id) {
            try {
                const res = await api.post(`/forms/${id}/publish`);
                // console.log(form);
                console.log(res);
            } catch (e) {
                alert(e.response?.data?.message);
                throw new Error(e.response?.data?.message);
            }
        },
        async deleteForm({ commit }, id) {
            try {
                const res = await api.delete(`/forms/${id}`);
                alert(res.data.message);
            } catch (error) {
                alert(e.response?.data?.message);
                throw new Error(e.response?.data?.message);
            }
        },
        async submituserForm({commit},formData){
           try {
            const res = await api.post(`/forms/${formData.id}/submit`,formData)
           } catch (error) {
            alert(e.response?.data?.message);
            throw new Error(e.response?.data?.message);

           }

        }
    },
};
