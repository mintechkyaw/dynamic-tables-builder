<template>
    <v-container class="mx-auto" color="secondary" max-width="full">
      <router-link to="/tables" class="my-2">
        <v-btn prepend-icon="fa-regular fa-share-from-square" size="small">Back</v-btn>
      </router-link>
      <v-alert
        v-if="successAlert"
        closable
        :text="successMessage"
        color="info"
        icon="$success"
      ></v-alert>
      <v-skeleton-loader  class="mt-2" v-if="isLoading" type="card"></v-skeleton-loader>

      <div v-else>
        <div v-for="form in publishedForms" :key="form.id">
          <TableSubmitPageReuse :form="form" :form_fields="form.form_fields" />
        </div>
      </div>
    </v-container>
  </template>

  <script>
  import { mapGetters } from "vuex";
import TableSubmitPageReuse from "./TableSubmitPageReuse.vue";

  export default {
    components: {
      TableSubmitPageReuse,
    },
    data() {
      return {
        valid: false,
        isLoading: false,
        btnloading: false,
        successMessage: "",
        successAlert: false,
        formData: {},
        publishedForms: [],
        rules: {
          required: (value) => !!value || "This field is required.",
        },
      };
    },
    computed: {
      ...mapGetters(["getForms", "authUser","getForm"]),
    },
    methods: {
      async fetchPublishedForms() {
        try {
          await this.$store.dispatch("fetchForms");
          const forms = this.getForms.filter(form => form.status === "published");
          this.publishedForms = await Promise.all(
            forms.map(async (form) => {
              await this.$store.dispatch("fetchFormById", form.id);
              return this.$store.getters.getForm;
            })
          );


        } catch (error) {
          console.error("Error fetching published forms:", error);
        }
      },
    },
    mounted() {
      this.isLoading = true;
      this.fetchPublishedForms().then(() => {
        this.isLoading = false;
      });
    },
  };
  </script>
