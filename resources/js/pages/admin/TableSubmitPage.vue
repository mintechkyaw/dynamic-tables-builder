<template>
    <v-app>
      <v-container>
        <!-- Form Title -->
        <v-card class="pa-5 mb-5">
          <v-card-title class="text-h5">{{ getForm?.name || "Dynamic Form" }}</v-card-title>
          <v-card-subtitle>{{ getForm?.slug || "Form Details" }}</v-card-subtitle>
        </v-card>

        <v-form ref="form" v-model="valid" style="max-height: 400px;">

          <!-- Render Fields Dynamically -->
          <div v-for="field in fields" :key="field.id" class="mb-4">
            <component
              :is="getFieldComponent(field.type)"
              v-model="formData[field.column_name]"
              :label="field.column_name"
              :items="field.type === 'radio' || field.type === 'check_box' ? parseOptions(field.options) : []"
              :rules="[field.required ? rules.required : () => true]"
              :type="field.data_type === 'integer' ? 'number' : 'text'"
              clearable
              outlined
              color="primary"
              class="w-full"
            />
          </div>

          <!-- Submit Button -->
          <v-btn :disabled="!valid" color="primary" @click="submitForm">
            Submit
          </v-btn>
        </v-form>
      </v-container>
    </v-app>
  </template>

  <script>
  import { mapGetters } from "vuex";

  export default {
    data() {
      return {
        valid: false,
        formData: {},
        fields: [],
        rules: {
          required: (value) => !!value || "This field is required.",
        },
      };
    },
    computed: {
      ...mapGetters(["getForm"]),
    },
    watch: {
      getForm: {
        handler(form) {
          if (form?.form_fields) {
            this.fields = form.form_fields;
            this.formData = form.form_fields.reduce((acc, field) => {
              acc[field.column_name] = "";
              return acc;
            }, {});
          }
        },
        immediate: true,
      },
    },
    methods: {
      getFieldComponent(type) {
        return {
          text: "v-text-field",
          radio: "v-radio",
          check_box: "v-checkbox",
          date: "v-date",
        }[type] || "v-text-field";
      },
      parseOptions(options) {
        return options ? JSON.parse(options) : [];
      },
      async submitForm() {
        if (this.$refs.form.validate()) {
          try {
            console.log("Submitting form data:", this.formData);
            alert("Form submitted successfully!");
          } catch (error) {
            console.error("Error submitting form:", error);
            alert("An error occurred while submitting the form.");
          }
        }
      },
      fetchFormData() {
        const id = this.$route.params.id;
        this.$store.dispatch("fetchFormById", id).catch((error) => {
          console.error("Error fetching form data:", error);
        });
      },
    },
    mounted() {
      this.fetchFormData();
    },
  };
  </script>
