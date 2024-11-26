<template>
<v-container>
    <div class=" mb-4">
        <h3 class="mb-2">Create Table</h3>
        <v-text-field v-model="form.formName" :rules="rules" hide-details="auto" label="Table Name" width="300" class="mb-1">
        </v-text-field>
        <v-text-field v-model="form.slug" :rules="rules" hide-details="auto" label="Slug" width="300" class="mb-1">
        </v-text-field>
        <v-btn @click="submitBtn" append-icon="fa-solid fa-plus" :loading="isLoading" :disabled="isLoading" variant="outlined">Add</v-btn>
    </div>

    <div>
        <h3>Table Lists</h3>
        <v-table>
            <thead>
                <tr>
                    <th class="text-left">
                        No
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Slug
                    </th>
                    <th class="text-left">
                        Status
                    </th>
                    <th class="text-left">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="form in getForms" :key="form.id">
                    <td>{{ form.id }}</td>
                    <td>{{ form.name }}</td>
                    <td>{{ form.slug }}</td>
                    <td>
                        <span v-if="form.status =='drafted'" class="text-red-lighten-1">{{ form.status }}</span>
                        <span v-else class="text-green-lighten-1">{{ form.status }}</span>
                    </td>
                    <td>
                        <router-link :to="`/form_field/${form.id}`">
                            <v-btn v-if="form.status =='drafted'" size="x-small" color="info" class="me-1">Add Fields</v-btn>
                        </router-link>
                        <v-btn @click="delBtn(form.id)" :loading="loadingStates[form.id]"
                        :disabled="loadingStates[form.id]"  size="x-small" color="error">Delete</v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </div>
</v-container>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex'
export default {
    data: () => ({
        rules: [
            value => !!value || 'Required.',
            value => (value && value.length >= 3) || 'Min 3 characters',
        ],
        form: {
            formName: '',
            slug: '',
        },
        errorMessage: "",
        isLoading: false,
        delBtnLoading: false,
        loadingStates: {},
    }),
    computed: {
        ...mapGetters(["getForms", "getForm"]),
    },
    methods: {
        ...mapActions(["fetchForms", "createForm", "fetchFormById", "deleteForm"]),
        async submitBtn() {
            try {
                this.isLoading = true;
                await this.createForm(this.form);
                this.form.formName = "";
                this.form.slug = "";
                alert("Successfully created.");
            } catch (error) {
                this.isLoading = false;
                alert(error.message);
            } finally {
                this.isLoading = false;
            }
        },
        async delBtn(id) {
            try {
                this.loadingStates[id] = true;
                await this.deleteForm(id);
                this.loadingStates[id] = true;
                this.fetchForms();
            } catch (error) {
                this.loadingStates[id] = true;
                alert(error.message);
            }
        }
    },
    mounted() {
        this.fetchForms();
    },
}
</script>

<style>

</style>
