<template>
  <v-container>
    <router-link to="/tables">
      <v-btn prepend-icon="fa-solid fa-arrow-left-long" size="small"
        >Back</v-btn
      >
    </router-link>
    <v-skeleton-loader
      v-if="isLoading"
      type="list-item-two-line"
    ></v-skeleton-loader>

    <v-list-item v-else lines="two" rounded></v-list-item>
    <v-form v-model="valid" v-if="!isLoading">
      <h4 class="my-2">{{ getForm?.name }}</h4>
      <div v-for="field in fields" :key="field.id" cols="12" md="6">
        <div v-if="field.type === 'text'">
          <v-text-field
            v-model="formData[field.column_name]"
            :label="field.column_name"
            :rules="[field.required ? rules.required : () => true]"
            clearable
            outlined
            color="primary"
            class="w-full"
          />
        </div>
        <div v-if="field.type === 'check_box'">
          <v-select
            v-model="formData[field.column_name]"
            :items="field?.options"
            item-value="value"
            :rules="[field.required ? rules.required : () => true]"
            item-text="label"
            :label="field.column_name"
            clearable
            outlined
            color="primary"
            multiple
          ></v-select>
        </div>

        <div v-if="field.type === 'radio'">
          <v-radio-group
            v-model="formData[field.column_name]"
            :label="field.column_name"
            :rules="[field.required ? rules.required : () => true]"
            color="primary"
            class="w-full"
          >
            <v-radio
              v-for="index in field.options"
              :key="index"
              :label="index"
              :value="index"
            />
          </v-radio-group>
        </div>

        <div v-if="field.type === 'calendar'" class="my-4">
          <div>
            <v-text-field
              type="date"
              v-model="formData[field.column_name]"
              required
            />
          </div>
        </div>
        <div v-if="field.type === 'number'">
          <v-text-field
            v-model="formData[field.column_name]"
            :label="field.column_name"
            type="number"
            :rules="[field.required ? rules.required : () => true]"
            clearable
            outlined
            color="primary"
            class="w-full"
          ></v-text-field>
        </div>
        <!-- <div>
                    <input type="hidden" v-model="formData[getForm.id]">
                </div> -->
      </div>

      <v-btn @click="onSubmit"
      variant="outlined"

        ><span
          :loading="btnloading"
          :disabled="btnloading"
          v-if="!btnloading"
          >Save</span
        >
        <v-progress-circular
        class="mx-1"
          v-if="btnloading"
          color="primary"
          indeterminate
        ></v-progress-circular>
      </v-btn>
    </v-form>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      valid: false,
      datePickerVisible: false,
      isLoading: false,
      btnloading: false,
      formData: {},
      id: null,
      fields: [],
      rules: {
        required: (value) => !!value || "This field is required.",
        email: (value) =>
          /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/.test(value) ||
          "Invalid email.",
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
          this.fields = form.form_fields.map((field) => ({
            id: field.id,
            column_name: field.column_name,
            type: field.type,
            options: field.options,
            required: field.required == 1,
            data_type: field.data_type,
          }));

          this.formData = {};
        }
      },
      immediate: true,
    },
  },
  methods: {
    parseOptions(options) {
      try {
        return options ? JSON.parse(options) : [];
      } catch (e) {
        console.error("Error parsing options:", e);
        return [];
      }
    },

    async onSubmit() {
      try {
        this.btnloading = true;
        await this.$store.dispatch("submituserForm", {
          ...this.formData,
          id: this.getForm?.id,
          status: this.getForm?.status,
          slug: this.getForm?.slug,
        });
      } catch (error) {
        console.error("Error submitting the form:", error);
      } finally {
        this.btnloading = false;
        this.formData = {}
      }
    },
  },
  mounted() {
    this.isLoading = true;
    this.$store
      .dispatch("fetchFormById", this.$route.params.id)
      .then(() => {
        this.isLoading = false;
      })
      .catch((error) => {
        console.error("Error fetching form:", error);
        this.isLoading = false;
      });
  },
};
</script>
