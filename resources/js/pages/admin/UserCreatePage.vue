<template>
<v-container>
    <v-row>
        <v-col cols="3"></v-col>
        <v-col cols="6">
            <h2 class="mb-2">Create User</h2>
            <v-text-field label="Enter Name"></v-text-field>
            <v-text-field label="Enter Email"></v-text-field>
            <v-text-field label="Enter Password" type="password"></v-text-field>
            <v-select label="Select Role" :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"></v-select>
            <v-checkbox label="Checkbox" color="primary"></v-checkbox>
            <v-btn variant="tonal">Create</v-btn>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
export default {
    data() {
        return {
            user:{
                name: '',
                email : '',
                role: '',
                password : '',
                permissions : [],
            }
        }
    },
}
</script>
