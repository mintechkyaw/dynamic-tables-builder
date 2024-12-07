<template>
<v-container>
    <div class=" mb-4" v-if="$can('create','form')">
        <h3 class="mb-2">Create Table</h3>
        <v-text-field v-model="form.formName" :rules="rules" hide-details="auto" label="Table Name" width="300" class="mb-1">
        </v-text-field>
        <v-text-field v-model="form.slug" :rules="rules" hide-details="auto" label="Slug" width="300" class="mb-1">
        </v-text-field>
        <v-btn @click="submitBtn" append-icon="fa-solid fa-plus" :loading="isLoading" :disabled="isLoading" variant="outlined">Add</v-btn>
    </div>

    <div>
        <h3>Table Lists</h3>
        <v-table v-if="$can('read','form')">
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
                        <router-link v-if="$can('update','form')" :to="`/form_field/${form.id}`">
                            <v-btn v-if="form.status =='drafted'" size="x-small" color="info" class="me-1">Add Fields</v-btn>
                        </router-link>
                        <v-dialog v-model="dialog" v-if="form.status =='drafted'" max-width="500">
                            <template v-slot:activator="{ props: activatorProps }">
                                <v-btn v-if="$can('update','form')" @click="editFormBtn(form.id)" v-bind="activatorProps" color="surface-variant" size="x-small" class="me-1" text="Edit" variant="flat"></v-btn>
                            </template>

                            <template v-slot:default="{ isActive }">
                                <v-card title="Edit">
                                    <v-text-field v-model="getForm.name" label="Form"></v-text-field>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>

                                        <v-btn text="Close" @click="isActive.value = false"></v-btn>
                                        <v-btn text="Update" @click="updateFormBtn(getForm)" :loading="updateFormBtnLoading"></v-btn>
                                    </v-card-actions>
                                </v-card>
                            </template>
                        </v-dialog>
                        <v-btn v-if="$can('delete','form')" @click="delBtn(form.id)" :loading="loadingStates[form.id]" :disabled="loadingStates[form.id]" size="x-small" color="error">Delete</v-btn>
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
import ability from '../../services/ability';
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
        editForm: "",
        updateFormBtnLoading: false,
        errorMessage: "",
        isLoading: false,
        delBtnLoading: false,
        loadingStates: {},
        dialog: false,
        isActive: {
            value: false,
        }
    }),
    computed: {
        ...mapGetters(["getForms", "getForm"]),
        $can() {
            return ability.can.bind(ability);
        }
    },
    methods: {
        ...mapActions(["fetchForms", "createForm", "fetchFormById", "deleteForm", "updateForm"]),
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
        },
        async editFormBtn(id) {
            try {
                this.editFormBtnLoading = true;
                await this.fetchFormById(id);
                this.editForm = this.getForm;
                this.dialog = true;
            } catch (e) {
                this.editFormBtnLoading = false;
                alert(e.message);
            }
        },
        async updateFormBtn(form) {
            try {
                this.updateFormBtnLoading = true;
                await this.updateForm(form);
                // this.updateFormBtnLoading = false;
                this.dialog = false;
                this.fetchForms();
            } catch (e) {
                this.updateFormBtnLoading = false;
                console.log(e.message);
            } finally {
                this.updateFormBtnLoading = false;
            }
        },
        closeDialog() {
            isActive.value = false;
        },
    },
    created() {
        if (this.$can('read', 'form')) {
            this.fetchForms();
        } else {
            console.warn('You do not have permission to read forms.');
        }
        console.log(ability.can('create','form'));
        console.log(ability.can('read','form'));
        console.log(ability.can('update','form'));
        console.log(ability.can('delete','form'));
    },
}
</script>

<style>

</style>
