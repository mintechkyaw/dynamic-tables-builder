<template>
<v-container fluid>
    <router-link to="/forms">
        <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small">Back</v-btn>
    </router-link>
    <v-row>
        <v-col cols="4">
            <div class="mb-2">
                <h1>Form Name: {{ getForm.name }}</h1>
                <p>Status: <span class="text-red-lighten-1 mb-5">{{ getForm.status }}</span></p>
            </div>
            <div>
                <v-card width="400" style="padding: 10px">
                    <v-text-field v-model="name" label="Field Name" outlined dense required></v-text-field>
                    <v-select v-model="selectedDataType" :items="fieldDataType" label="Select Data Type" outlined dense required></v-select>
                    <!-- <p class="mt-3">Selected Data Type: {{ selectedDataType }}</p> -->
                    <div v-if="['json', 'enum'].includes(selectedDataType)">
                        <div>
                            <h4>Options</h4>
                            <h5 v-for="(option,index) in options" :key="index" class="mb-1">{{ option }}
                                <v-btn @click="removeOption" size="x-small" color="warning">Remove</v-btn>
                            </h5>
                        </div>
                        <v-text-field v-model="newOption" label="Add Option" outlined dense></v-text-field>
                        <v-btn @click="addOption" color="primary" class="mt-2" size="x-small">Add Option</v-btn>
                    </div>
                    <v-col>
                        <v-switch v-model="required" hide-details inset></v-switch>
                        <h4>Require: {{ required }}</h4>
                    </v-col>
                    <v-btn @click="submitField" :loading="isLoading" append-icon="fa-solid fa-plus" size="small" color="info" class="mt-4">Submit</v-btn>
                </v-card>
            </div>
        </v-col>
        <v-col cols="8">
            <div class="mb-2">
                <h1>Field Lists</h1>
                <p>Status: <span class="text-red-lighten-1 mb-5">{{ getForm.status }}</span></p>
            </div>
            <div>
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
                            <td>{{ field.options }}</td>
                            <td><v-btn @click="deleteFieldBtn(field.id)" size="x-small" color="danger" icon="fa-regular fa-trash-can"></v-btn></td>
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

export default {
    data() {
        return {
            fieldDataType: ['string', 'integer', 'json', 'enum', 'date'],
            newOption: "",
            name: "",
            selectedDataType: "",
            type: "",
            options: [],
            required: false,
            isLoading: false,
        }
    },
    computed: {
        ...mapGetters(["getForm"]),
        formFields() {
            return this.getFormFields;
        },
        fieldType() {
            const typeMapping = {
                string: "text",
                integer: "number",
                json: "check_box",
                enum: "radio",
                date: "calendar",
            };
            return typeMapping[this.selectedDataType] || "unknown";
        },
    },
    async created() {
        const formId = this.$route.params.id;
        await this.fetchFormById(formId);
    },
    methods: {
        ...mapActions(["fetchFormById", "submitFormField","deleteField"]),
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
            if (!this.selectedDataType) {
                alert("Please select a data type.");
                return;
            }
            const fieldData = {
                form_id: this.$route.params.id,
                column_name: this.name,
                data_type: this.selectedDataType,
                type: this.fieldType,
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
        },
        clearField() {
            this.name = "";
            this.selectedDataType = "";
            this.type = "";
            this.options = [];
            this.required = false;
        },
        async deleteFieldBtn(id){
            await this.deleteField(id);
            const formId = this.$route.params.id;
            this.fetchFormById(formId);
        }
    },
}
</script>
