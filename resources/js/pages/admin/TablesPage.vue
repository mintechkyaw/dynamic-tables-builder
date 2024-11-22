<template>
    <v-app>
        <v-container>
            <v-row>
                <v-col
                    v-for="table in publishedTables"
                    :key="table.id"
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    class="mt-4"
                >
                    <v-card
                        outlined
                        class="pa-4 text-center"
                        @click="SubmitTable(table.id)"
                    >
                        <v-card-title class="text-h6 font-weight-bold">
                            {{ table.name }}
                        </v-card-title>
                        <v-card-subtitle>
                            <span class="text-success">
                                {{ table.status }}
                            </span>
                        </v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    computed: {
        ...mapGetters(["getForms"]),
        publishedTables() {
            return this.getForms?.filter((table) => table.status === "published");
        },
    },
    methods: {
        async fetchTables() {
            await this.$store.dispatch("fetchForms");
        },
        SubmitTable(id) {
            this.$router.push(`/tables/${id}`);
        },
    },
    mounted() {
        this.fetchTables();
    },
};
</script>
