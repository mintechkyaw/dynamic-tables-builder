<template>
<div class="d-flex justify-center items-center">
    <div class="w-25 mt-16">
        <h2 class=" mb-3">Login</h2>
        <v-alert v-if="errorMessage" type="error" class="mt-3 mb-2" dense>
            {{ errorMessage }}
        </v-alert>
        <v-text-field v-model="submitUser.email" :rules="[rules.required,rules.email]" name="email" label="Email" type="email"></v-text-field>
        <v-text-field v-model="submitUser.password" :rules="[rules.required]" name="password" label="Password" type="password" required></v-text-field>
        <v-btn @click="submit" block color="primary" :loading="isLoading" :disabled="isLoading">Login</v-btn>
    </div>
</div>
</template>

<script>
import {
    mapActions
} from 'vuex';

export default {
    data() {
        return {
            submitUser: {
                email: '',
                password: '',
            },
            errorMessage: "",
            isLoading: false,
            isFormValid: false,
            rules: {
                required: (value) => !!value || 'This field is required.',
                email: (value) =>
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || 'Please enter a valid email address.',
            },
        }
    },
    methods: {
        ...mapActions(["loginUser"]),
        async submit() {
            this.isLoading = true;
            try {
                await this.loginUser(this.submitUser);
                this.$router.push("/");
            } catch (error) {
                this.errorMessage = error.message || "An unexpected error occurred.";
            } finally {
                this.isLoading = false;
            }
        },
    },
}
</script>
