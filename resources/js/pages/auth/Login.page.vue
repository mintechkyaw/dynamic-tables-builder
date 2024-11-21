<template>
<div class="d-flex justify-center items-center">
    <div class="w-25 mt-16">
        <h2 class=" mb-3">Login</h2>
       <v-text-field
        name="email"
        label="Email"
       type="email"
       ></v-text-field>
       <v-text-field
        name="password"
        label="Password"
       type="password"
       ></v-text-field>
        <v-btn color="dark">Login</v-btn>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            rules: {
                required: (value) => !value || "required",
                email: (value) =>
                    /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/.test(value) ||
                    "Invalid email.",
            }
        }
    },
}
</script>

<style>

</style>
