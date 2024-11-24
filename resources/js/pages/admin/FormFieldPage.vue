<template>
<v-container>
    <router-link to="/forms">
        <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small">Back</v-btn>
    </router-link>
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
            <v-btn @click="submitField" append-icon="fa-solid fa-plus" size="small" color="info" class="mt-4">Submit</v-btn>
        </v-card>
    </div>
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
        ...mapActions(["fetchFormById", "submitFormField"]),
        addOption() {
            if (this.newOption.trim() !== "") {
                this.options.push(this.newOption.trim());
                this.newOption = "";
            }
        },
        removeOption(index) {
            this.options.splice(index, 1); // Remove option by index
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
            await this.submitFormField(
                fieldData
            );
        }
    },
}
</script>
