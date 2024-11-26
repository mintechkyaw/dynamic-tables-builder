<template>
<v-container fluid>
    <router-link to="/">
        <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small">Back</v-btn>
    </router-link>
    <div class="mb-2">
        <h1>Field Lists</h1>
        <p>Status: <span class="text-red-lighten-1 mb-5">{{ getForm.status }} {{ getForm.user_id }}</span></p>
    </div>
    <div>
        <v-table>
            <thead>
                <tr>
                    <th>Column</th>
                    <th>DataType</th>
                    <th>Type</th>
                    <th>Options</th>
                    <th>Required</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="field in getForm.form_fields" :key="field.id">
                    <td>{{ field.column_name }}</td>
                    <td>{{ field.data_type }}</td>
                    <td>{{field.type}}</td>
                    <td>{{ field.options }}</td>
                    <td>{{ field.required ? "True" : "False" }}</td>
                </tr>
            </tbody>
        </v-table>
    </div>
</v-container>
</template>

<script>
import {
    mapGetters,
    mapActions
} from 'vuex';

export default {
    methods: {
        ...mapActions(["fetchFormById"]),
    },
    computed: {
        ...mapGetters(["getForm"]),
    },
    async created() {
        const formId = this.$route.params.id;
        await this.fetchFormById(formId);
        console.log(this.form);
    },
}
</script>

<style>
</style>
