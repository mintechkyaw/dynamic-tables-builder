<template>
    <v-app>
      <v-container class="mt-3">
        <h3 class="my-2">Forms Lists</h3>
        <v-data-table-server
         :items="getResponseForms?.data"
         :items-length="totalItems"
        >
        <template v-slot:item="{ item }">
      <tr>
        <td>{{ item }}</td>

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
        totalItems: 0,
        loading: false,
      };
    },
    computed: {
      ...mapGetters(["getResponseForms"]),
    },
    watch: {
        getResponseForms(forms) {
          this.totalItems = forms.data?.length;
        }
        },
    methods: {
      async fetchResponseTables(id) {
        this.loading = true;
        try {
          await this.$store.dispatch("fetchResponseTables",id);
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
    }

  };
  </script>
