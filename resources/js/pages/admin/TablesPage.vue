<template>
    <v-app>
        <v-container class="mt-3">
            <h3 class="my-2">Forms Lists</h3>
            <v-data-table-server
                :items="publishedTables"
                :headers="headers"
                :items-per-page="10"
                :loading="loading"
                :items-length="totalItems"
                @update:options="fetchTables"
            >
                <template v-slot:body="{ items }">
                    <tr v-for="item in items" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td class="text-success">{{ item.status }}</td>
                        <td>
                            <v-btn @click="SubmitTable(item.id)"
                                ><i class="fa-solid fa-eye"></i
                            ></v-btn>
                            <v-btn
                                class="ms-2"
                                @click="
                                    responseTableLists(this.$route.params.id)
                                "
                            >
                                <i class="fa-solid fa-file-circle-plus"></i>
                            </v-btn>
                        </td>
                    </tr>
                </template>
            </v-data-table-server>
        </v-container>
    </v-app>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            headers: [
                { title: "ID", value: "id" },
                { title: "Name", value: "name" },
                { title: "Status", value: "status" },
                { title: "Actions", value: "actions", sortable: false },
            ],
            publishedTables: [],
            totalItems: 0,
            loading: false,
        };
    },
    computed: {
        ...mapGetters(["getForms"]),
    },
    watch: {
        getForms(value) {
            this.publishedTables = value.filter(
                (table) => table.status === "published"
            );
            this.totalItems = this.publishedTables.length;
        },
    },
    methods: {
        async fetchTables() {
            this.loading = true;
            try {
                await this.$store.dispatch("fetchForms");
            } catch (error) {
                console.error("Error fetching forms:", error);
            } finally {
                this.loading = false;
            }
        },
        SubmitTable(id) {
            this.$router.push(`/tables/${id}`);
        },
        responseTableLists(id) {
            this.$router.push({
                name: "ResponseTableLists",
                params: { id: id },
            });
        },
    },
};
</script>
