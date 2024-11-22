<template>
    <v-app>
      <v-container>
        <!-- Form Title -->
        <v-card class="pa-5">
          <v-card-title class="text-h5">{{ formandfields?.name || "Form" }}</v-card-title>
          <v-card-subtitle>{{ formandfields?.slug || "Dynamic Form" }}</v-card-subtitle>
        </v-card>

        <!-- Form -->
        <v-form ref="form" v-model="valid" class="mt-5">
          <v-row>
            <!-- Dynamic Fields -->
            <v-col
              v-for="field in formandfields"
              :key="field.id"
              cols="12"
              sm="6"
              md="4"
              class="mb-4"
            >
              <!-- Render Fields Based on Type -->
              <component
                :is="getFieldComponent(field.type)"
                v-model="formData[field.column_name]"
                :label="field.column_name"
                :options="field.options ? JSON.parse(field.options) : []"
                :rules="[field.required ? rules.required : () => true]"
                :type="field.data_type"
                required
              />
            </v-col>
          </v-row>

          <!-- Submit Button -->
          <v-btn :disabled="!valid" color="primary" @click="submitForm">
            Submit
          </v-btn>
        </v-form>
      </v-container>
    </v-app>
  </template>

  ---

  ### Script Section
  ```javascript
  <script>
  import { mapGetters } from "vuex/dist/vuex.cjs.js";

  export default {
    data() {
      return {
        valid: false, // Form validation state
        formData: {}, // Stores dynamic form values
        rules: {
          required: (value) => !!value || "This field is required.",
          email: (value) =>
            /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/.test(value) ||
            "Invalid email.",
        },
      };
    },
    computed: {
      ...mapGetters(["formandfields"]),
    },
    watch: {
      formandfields: {
        handler(value) {
          if (value?.form_fields) {
            value.form_fields.forEach((field) => {
              this.$set(this.formData, field.column_name, "");
            });
          }
        },
        immediate: true,
      },
    },
    methods: {
      getFieldComponent(type) {
        const componentMap = {
          text: "v-text-field",
          radio: "v-radio-group",
          check_box: "v-checkbox",
          date: "v-date-picker",
        };
        return componentMap[type] || "v-text-field";
      },
      async submitForm() {
        if (this.$refs.form.validate()) {
          try {
            const response = await fetch("https://example.com/api/submit", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify(this.formData),
            });
            const result = await response.json();
            alert("Form submitted successfully!");
            console.log(result);
          } catch (error) {
            console.error("Error submitting form:", error);
            alert("An error occurred while submitting the form.");
          }
        }
      },
      async fetchFormandFieldsData() {
        console.log("Fetching form and fields data...");
        const id = this.$route.params.id;
        try {
          await this.$store.dispatch("formandfields", id);
        } catch (error) {
          console.error("Error fetching form and fields data:", error);
        }
      },
    },
    mounted() {
      this.fetchFormandFieldsData();
    },
  };
  </script>

<!-- async formandfields({ commit }, id) {
    try {
        const res = await api.get(`/forms/${id}`, {
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        commit("SET_FORM_DATA", res.data); // Update formData with API response
    } catch (error) {
        console.error("Error fetching form data:", error);
    }
}, -->
