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
            <v-text-field v-model="form.name" label="Field Name" outlined dense required></v-text-field>
            <v-select v-model="form.selectedDataType" :items="fieldDataType" label="Select Data Type" outlined dense required></v-select>
            <!-- <p class="mt-3">Selected Data Type: {{ selectedDataType }}</p> -->

            <div v-if="['json', 'enum'].includes(form.selectedDataType)">
                <div>
                    <h4>Options</h4>
                    <h5 v-for="(option,index) in forms.options" :key="index" class="mb-1">{{ option }}
                        <v-btn @click="removeOption" size="x-small" color="warning">Remove</v-btn>
                    </h5>
                </div>
                <v-text-field v-model="newOption" label="Add Option" outlined dense></v-text-field>
                <v-btn @click="addOption" color="primary" class="mt-2" size="x-small">Add Option</v-btn>
            </div>
            <v-col>
                <v-switch v-model="form.require" hide-details inset></v-switch>
                <h4>Require: {{ form.require }}</h4>
            </v-col>
            <v-btn @click="submitField(form)" append-icon="fa-solid fa-plus" size="small" color="info" class="mt-4">Submit</v-btn>
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
            selectedDataType: "",
            newOption: "",
            // options: [],
            // isRequired: false,
            form: {
                name: "",
                selectedDataType: "",
                type: "",
                options: [],
                required: false,
            }
        }
    },
    computed: {
        ...mapGetters(["getForm"]),
    },
    async created() {
        const formId = this.$route.params.id;
        await this.fetchFormById(formId);
    },
    methods: {
        ...mapActions(["fetchFormById","submitFormField"]),
        addOption() {
            if (this.newOption.trim() !== "") {
                this.options.push(this.newOption.trim()); // Add new option to the options array
                this.newOption = ""; // Clear the input field
            }
        },
        removeOption(index) {
            this.options.splice(index, 1); // Remove option by index
        },
        async submitField(form){
            // await this.submitFormField(form);
            console.log(form);
        }
    }
}
</script>
