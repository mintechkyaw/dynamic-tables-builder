<template>
    <v-app>
      <v-container>
        <!-- <h1>Table Name</h1> -->
        <v-form ref="form" v-model="valid">
          <!-- Email Input -->
          <v-text-field
            v-model="formData.email"
            label="Email *"
            :rules="[rules.required, rules.email]"
            required
            class="mb-4"
          ></v-text-field>

          <!-- Multiple Choice Question -->
          <div class="mb-4">
            <h4>Untitled Question *</h4>
            <v-radio-group
              v-model="formData.question"
              :rules="[rules.required]"
              required
            >
              <v-radio
                v-for="(option, index) in options"
                :key="index"
                :label="option"
                :value="option"
              ></v-radio>
            </v-radio-group>
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
export default {
  data() {
    return {
      valid: false,
      // Form data
      formData: {
        email: "",
        question: "",
      },
      // Question options
      options: [
        "Option 1",
        "Et fugiat qui in qu",
        "Option 3",
        "Ea voluptas ut recus",
        "Option 5",
        "Ipsa libero sunt ir",
        "Option 7",
      ],
      // Validation rules
      rules: {
        required: (value) => !!value || "This field is required.",
        email: (value) =>
          /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/.test(value) ||
          "Invalid email.",
      },
    };
  },
  methods: {
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
  },
};
</script>
