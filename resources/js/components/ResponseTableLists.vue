
<template>
    <v-app>
        <v-container class="mt-3">
            <div class="d-flex justify-space-between align-center">
                <router-link to="/tables" class="my-2">
                    <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small">Back</v-btn>
                </router-link>
                <v-btn
                    @click="exportToExcel"
                    :disabled="!hasData"
                   color="success"
                    prepend-icon="fas fa-file-excel"
                    :loading="loading"
                >
                    Export
                </v-btn>
            </div>
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
import axios from 'axios';

export default {
    data() {
        return {
            totalItems: 0,
            loading: false,
        };
    },
    computed: {
        ...mapGetters(["getResponseForms"]),
        hasData() {
            return this.getResponseForms?.data?.length > 0;
        },
        transformedData() {
            return this.getResponseForms?.data?.map((item) => {
                const transformedItem = { ...item };
                for (const key in transformedItem) {
                    if (Array.isArray(transformedItem[key])) {
                        transformedItem[key] = transformedItem[key].join(", ");
                    }
                }
                return transformedItem;
            }) || [];
        },
    },
    watch: {
        getResponseForms(forms) {
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
        async exportToExcel() {
            try {
                const id = this.$route.params.id;

                const response = await axios.get(`/api/forms/${id}/export`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },
                    responseType: 'blob'  // Important for file download
                });

                // Get form name from store or use a default name
                const fileName = this.getResponseForms?.data[0]?.name || 'form-data';

                // Create download link
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `${fileName}_data.xlsx`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error('Export failed:', error);
                // Use alert box
                alert('Export failed: ' + error.message);
            }
        }
    },
};
</script>
