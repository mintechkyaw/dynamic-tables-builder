<template>
<div>
    <router-link to="/forms">
        <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small">Back</v-btn>
    </router-link>
    <h1>Form Name: {{ getForm.name }}</h1>
    <p>Status: <span class="text-red-lighten-1 mb-5">{{ getForm.status }}</span></p>
    <v-btn append-icon="fa-solid fa-plus" size="small" color="info">Add Field</v-btn>
</div>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';

export default {
    computed: {
        ...mapGetters(["getForm"]),
    },
    async created() {
        const formId = this.$route.params.id;
        await this.fetchFormById(formId);
    },
    methods: {
        ...mapActions(["fetchFormById"]),
    }
}
</script>
