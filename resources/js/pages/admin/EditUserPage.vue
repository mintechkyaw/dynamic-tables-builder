<template>
<v-container>
    <div>
    <v-text-field :rules="rules" hide-details="auto" label="Main input"></v-text-field>
    <v-text-field label="Another input"></v-text-field>
</div>
</v-container>
</template>

<script>
import {
    mapActions
} from 'vuex';

export default {
    methods: {
        ...mapActions(["fetchUserById"]),
    },
    mounted() {
        const userId = this.$route.params.id;
        this.fetchUserById(this.$route.params.id);
        console.log(this.$route.params.id);
    },
}
</script>
