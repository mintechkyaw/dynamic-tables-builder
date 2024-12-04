<template>
  <v-container>
    <v-row>
      <v-col cols="3"></v-col>
      <v-col cols="6">
        <h3 class="mb-2">Create User</h3>
        <v-text-field
          label="Enter Name"
        ></v-text-field>
        <v-text-field
          label="Enter Email"
        ></v-text-field>
        <v-text-field
          label="Enter Phone"
        ></v-text-field>
        <v-select
          label="Select Role"
          :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        ></v-select>
        <v-checkbox label="Checkbox" color="primary"></v-checkbox>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>
