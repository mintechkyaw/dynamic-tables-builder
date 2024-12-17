<template>
    <v-container>
      <!-- Card for the Form -->
      <v-card elevation="2" class="pa-4 mb-4">
        <v-card-title>
          <h4 class="my-3 bg-primary px-2 py-4 rounded">{{ form.name }}</h4>
        </v-card-title>
        <v-card-text>
          <v-form v-model="valid">
            <div v-for="field in form.form_fields" :key="field.id" cols="12" md="6">
              <!-- Text Field -->
              <v-text-field
                v-if="field.type === 'text'"
                v-model="formData[field.column_name]"
                :label="field.column_name"
                :rules="[field.required ? rules.required : () => true]"
                clearable
                outlined
                color="primary"
                class="w-full"
              ></v-text-field>

              <!-- Checkbox/Multiselect -->
              <v-select
                v-if="field.type === 'check_box'"
                v-model="formData[field.column_name]"
                :items="field.options"
                :label="field.column_name"
                :rules="[field.required ? rules.required : () => true]"
                clearable
                outlined
                color="primary"
                multiple
              ></v-select>

              <!-- Radio Group -->
              <v-radio-group
                v-if="field.type === 'radio'"
                v-model="formData[field.column_name]"
                :label="field.column_name"
                :rules="[field.required ? rules.required : () => true]"
                color="primary"
                class="w-full"
              >
                <v-radio
                  v-for="option in field.options"
                  :key="option"
                  :label="option"
                  :value="option"
                ></v-radio>
              </v-radio-group>

              <!-- Date Field -->
              <v-text-field
                v-if="field.type === 'calendar'"
                type="date"
                v-model="formData[field.column_name]"
                :label="field.column_name"
                outlined
                clearable
                color="primary"
              ></v-text-field>

              <!-- Number Field -->
              <v-text-field
                v-if="field.type === 'number'"
                type="number"
                v-model="formData[field.column_name]"
                :label="field.column_name"
                :rules="[field.required ? rules.required : () => true]"
                clearable
                outlined
                color="primary"
                class="w-full"
              ></v-text-field>
            </div>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <!-- Save Button -->
          <v-btn
            @click="onSubmit"
            variant="outlined"
            :disabled="btnloading"
            color="primary"
            class="ms-3 my-2"
            :loading="btnloading"
          >
            <template v-if="!btnloading">Save</template>
            <template v-if="btnloading">
              <v-progress-circular
                class="mx-1"
                color="primary"
                indeterminate
                size="24"
              ></v-progress-circular>
            </template>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-container>
  </template>

  <script>
  export default {
    props: {
      form: Object,
    },
    data() {
      return {
        valid: false,
        isLoading: false,
        btnloading: false,
        formData: {},
        rules: {
          required: (value) => !!value || "This field is required.",
        },
      };
    },
    methods: {
      async onSubmit() {
        try {
          this.btnloading = true;
          await this.$store.dispatch("submituserForm", {
            ...this.formData,
            id: this.form.id,
          });
          alert("Form submitted successfully!");
        } catch (error) {
          console.error("Error submitting the form:", error);
        } finally {
          this.btnloading = false;
          this.formData = {};
        }
      },
    },
  };
  </script>
