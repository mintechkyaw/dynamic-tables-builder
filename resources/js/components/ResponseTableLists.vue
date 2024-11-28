<template>
    <v-app>
        <v-container class="mt-3">
            <h3 class="my-2">Forms Lists</h3>
            <v-data-table-server
                :items="transformedData"
                :items-length="totalItems"
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
            // headers: [],
        };
    },
    computed: {
        ...mapGetters(["getResponseForms"]),
        transformedData() {
            return this.getResponseForms?.data.map(item => {
                const transformedItem = { ...item };
                for (const key in transformedItem) {
                    if (Array.isArray(transformedItem[key])) {
                        transformedItem[key] = transformedItem[key].join(', ');
                    }
                }
                return transformedItem;
            });
        }
    },
    watch: {
        getResponseForms(forms) {
            console.log(forms);

            this.totalItems = forms.data?.length;
            // if (forms?.headers?.length) {
            //     this.headers = forms.headers.map((key) => ({
            //         title: key,
            //         value: key,
            //     }));
            // }
        },
    },
    methods: {
        async fetchResponseTables(id) {
            this.loading = true;
            try {
                await this.$store.dispatch("fetchResponseTables", id);
            } catch (error) {
                console.error("Error fetching forms:", error);
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        const id = this.$route.params.id;
        this.fetchResponseTables(id);
    },
};
</script>
