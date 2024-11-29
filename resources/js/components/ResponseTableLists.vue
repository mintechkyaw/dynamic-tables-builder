<template>
    <v-app>
        <v-container class="mt-3">
            <router-link to="/tables" class="my-2">
                <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small"
                    >Back</v-btn
                >
            </router-link>
            <!-- <h3 class="my-2">Forms Lists</h3> -->
            <v-data-table-server
                class="mt-6"
                :items="transformedData"
                :items-length="totalItems"
                @update:options="fetchResponseTables"
                :loading="loading"
            >
            </v-data-table-server>
        </v-container>
    </v-app>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            totalItems: 0,
            loading: false,
        };
    },
    computed: {
        ...mapGetters(["getResponseForms"]),
        transformedData() {
            return this.getResponseForms?.data.map((item) => {
                const transformedItem = { ...item };
                for (const key in transformedItem) {
                    if (Array.isArray(transformedItem[key])) {
                        transformedItem[key] = transformedItem[key].join(", ");
                    }
                }
                return transformedItem;
            });
        },
    },
    watch: {
        getResponseForms(forms) {
            console.log(forms);

            this.totalItems = forms.pagination?.total;
            this.itemsPerPage = forms.pagination?.per_page;
        },
    },
    methods: {
        async fetchResponseTables({
            page = 1,
            itemsPerPage = 10,
        } = {}) {
            const id = this.$route.params.id;
            this.loading = true;
            try {
                await this.$store.dispatch("fetchResponseTables", {
                    id: id,
                    page: page,
                    per_page: itemsPerPage,
                });
            } catch (error) {
                console.error("Error fetching forms:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
