<template>
<v-container fluid>
    <router-link to="/forms">
        <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small">Back</v-btn>
    </router-link>
    <v-row>
        <v-col cols="12" md="4">
            <div class="mb-2">
                <h1>Form Name: {{ getForm.name }}</h1>
                <p>Status: <span class="text-red-lighten-1 mb-5">{{ getForm.status }}</span></p>
            </div>
            <div>
                <v-card style="padding: 1rem">
                    <v-text-field v-model="name" label="Field Name" outlined dense required></v-text-field>
                    <v-select v-model="type" :items="fieldDataType" label="Select Field Type" outlined dense required></v-select>
                    <div v-if="['check_box', 'radio'].includes(type)">
                        <div>
                            <h4>Options</h4>
                            <v-list v-for="(option,index) in options" :key="index" class="mb-1">
                                <span>{{ option }}</span>
                                <v-btn @click="removeOption(index)" size="x-small" color="warning" icon="fa fa-trash" variant="plain"></v-btn>
                            </v-list>
                        </div>
                        <v-text-field v-model="newOption" label="Add Option" outlined dense></v-text-field>
                        <v-btn @click="addOption" color="primary" class="mt-2" size="x-small">Add Option</v-btn>
                    </div>
                    <v-col>
                        <v-switch v-model="required" color="primary" hide-details inset label="Required"></v-switch>
                    </v-col>
                    <v-btn @click="submitField" :loading="isLoading" append-icon="fa-solid fa-plus" size="small" color="info" class="mt-4">Submit</v-btn>
                </v-card>
            </div>
        </v-col>
        <v-col cols="12" md="8">
            <div class="mb-2">
                <h1>Field Lists</h1>
                <p>Status: <span class="text-red-lighten-1 mb-5">{{ getForm.status }} {{ getForm.user_id }}</span></p>
            </div>
            <div>
                <v-btn :loading="publishBtn" @click="submitFormToDatabaseBtn(getForm.id)" color="success">Create Table</v-btn>
                <v-table>
                    <thead>
                        <tr>
                            <th>Column</th>
                            <th>DataType</th>
                            <th>Type</th>
                            <th>Options</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="field in getForm.form_fields" :key="field.id">
                            <td>{{ field.column_name }}</td>
                            <td>{{ field.data_type }}</td>
                            <td>{{field.type}}</td>
                            <td><v-chip color="primary" variant="flat" class="me-1" v-for="option in field.options" :key="option.id">{{ option }}</v-chip> </td>
                            <td>
                                <v-btn @click="deleteFieldBtn(field.id)" size="x-small" color="danger" icon="fa-regular fa-trash-can"></v-btn>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </div>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';
import ability from '../../services/ability';

export default {
    data() {
        return {
            fieldDataType: ['text', 'number', 'check_box', 'radio', 'calendar'],
            newOption: "",
            name: "",
            type: "",
            options: [],
            required: false,
            isLoading: false,
            form: {},
            publishBtn :false,
        }
    },
    computed: {
        ...mapGetters(["getForm"]),
        formFields() {
            return this.getFormFields;
        },
    },
    async created() {
        const formId = this.$route.params.id;
        await this.fetchFormById(formId);
        console.log(this.form);
    },
    methods: {
        ...mapActions(["fetchFormById", "submitFormField", "deleteField", "submitFormToDatabase"]),
        addOption() {
            if (this.newOption.trim() !== "") {
                this.options.push(this.newOption.trim());
                this.newOption = "";
            }
        },
        removeOption(index) {
            this.options.splice(index, 1);
        },
        async submitField() {
            try {
                if (!this.fieldDataType.includes(this.type)) {
                alert("Please select a valid field type.");
                return;
            }
            const fieldData = {
                form_id: this.$route.params.id,
                column_name: this.name,
                type: this.type,
                options: this.options.length ? this.options : null,
                required: this.required ? 1 : 0,
            }
            this.isLoading = true;
            await this.submitFormField(
                fieldData
            );
            this.isLoading = false;
            this.clearField();
            const formId = this.$route.params.id;
            this.fetchFormById(formId);
            } catch (e) {
                this.isLoading = false;
                console.log(e.message);
            }
        },
        clearField() {
            this.name = "";
            this.type = "";
            this.options = [];
            this.required = false;
        },
        async deleteFieldBtn(id) {
            await this.deleteField(id);
            const formId = this.$route.params.id;
            this.fetchFormById(formId);
        },
        async submitFormToDatabaseBtn(id) {
            this.publishBtn = true;
            await this.submitFormToDatabase(id);
            this.publishBtn = false;
            this.$router.push("/forms");
        },
        $can(){
            return ability.can.bind(ability);
        }
    },
}
</script>
