<template>
<v-container>
    <h3 class="mb-2">Create Table</h3>
    <v-text-field v-model="form.formName" :rules="rules" hide-details="auto" label="Table Name" width="300" class="mb-1">
    </v-text-field>
    <v-text-field v-model="form.slug" :rules="rules" hide-details="auto" label="Slug" width="300" class="mb-1">
    </v-text-field>
    <v-btn @click="submitBtn" append-icon="fa-solid fa-plus" :loading="isLoading" :disabled="isLoading" variant="outlined">Add</v-btn>
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
    }),
    computed: {
       ...mapGetters(["getForms","getForm"]),
    },
    methods: {
        ...mapActions(["createForm","fetchFormById"]),
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
        }
    },
    mounted () {
        // console.log(this.getForms);
    },
}
</script>

<style>

</style>
