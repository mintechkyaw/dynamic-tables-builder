<template>
<v-container fluid>
    <h2>Table Lists</h2>
    <v-table>
        <thead>
            <tr>
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
                <td>{{ form.name }}</td>
                <td>{{ form.slug }}</td>
                <td>{{ form.status }}</td>
                <td>
                    <router-link :to="`/details/${form.id}`">
                        <v-btn size="x-small" color="success" class="me-1">View</v-btn>
                    </router-link>
                </td>
            </tr>
        </tbody>
    </v-table>
</v-container>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex'
export default {
    computed: {
        ...mapGetters(["getForms"]),
    },
    methods: {
        ...mapActions(["fetchForms"])
    },
    mounted() {
        this.fetchForms();
    },
}
</script>

<style>

</style>
